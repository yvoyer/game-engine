<?php declare(strict_types=1);

namespace Star\GameEngine;

use PHPUnit\Framework\TestCase;
use RuntimeException;
use Star\GameEngine\Context\DuplicatedGameContext;
use Star\GameEngine\Context\GameContext;
use Star\GameEngine\Context\GameContextNotFound;
use Star\GameEngine\Context\SingleContextByName;
use Star\GameEngine\Extension\Callback\CallbackPlugin;
use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\Messaging\DuplicateListenerForEvent;
use Star\GameEngine\Messaging\DuplicatePriorityForEventListener;
use Star\GameEngine\Messaging\Event\GameEngineEvents;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\HandlerNotFound;
use Star\GameEngine\Messaging\Queries\QueryResult;
use Star\GameEngine\Testing\Stub\DoGameCommand;
use Star\GameEngine\Testing\Stub\EventOccurred;
use Star\GameEngine\Testing\Stub\EventSpy;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use function func_get_args;
use function get_class;
use function sprintf;

final class GameEngineTest extends TestCase
{
    public function test_event_dispatch_should_be_dispatched(): void
    {
        $engine = new GameEngine();
        $dispatched = false;
        $engine->addPlugin(
            $plugin = new CallbackPlugin(
                [
                    GameEngineEvents::GAME_EVENT => function (EventOccurred $event) use (&$dispatched) {
                        $dispatched = $event instanceof EventOccurred;
                    },
                ]
            )
        );

        $this->assertFalse($dispatched);

        $engine->dispatchEvent(new EventOccurred('event'));

        $this->assertTrue($dispatched);
    }

    public function test_command_should_be_dispatched(): void
    {
        $engine = new GameEngine();
        $dispatched = false;
        $engine->addPlugin(
            $plugin = new CallbackPlugin(
                [],
                [
                    DoGameCommand::class => function () use (&$dispatched) {
                        $dispatched = true;
                    },
                ]
            )
        );

        $this->assertFalse($dispatched);

        $engine->dispatchCommand(new DoGameCommand());

        $this->assertTrue($dispatched);
    }

    public function test_it_should_return_the_context(): void
    {
        $engine = new GameEngine();
        $this->assertFalse($engine->hasContext('name'));

        $engine->addContextBuilder(
            new SingleContextByName('name', $this->createMock(GameContext::class))
        );

        $this->assertTrue($engine->hasContext('name'));
        $this->assertInstanceOf(GameContext::class, $engine->getContext('name'));
    }

    public function test_it_should_throw_exception_when_context_not_found(): void
    {
        $engine = new GameEngine();
        $this->assertFalse($engine->hasContext('not-found'));

        $this->expectException(GameContextNotFound::class);
        $this->expectExceptionMessage('The game context "not-found" could not be found.');
        $engine->getContext('not-found');
    }

    public function test_it_should_throw_exception_when_context_already_set(): void
    {
        $engine = new GameEngine();
        $engine->addContextBuilder(
            new SingleContextByName('name', $this->createMock(GameContext::class))
        );
        $this->assertTrue($engine->hasContext('name'));

        $this->expectException(DuplicatedGameContext::class);
        $this->expectExceptionMessage('The game context "name" is already set.');
        $engine->addContextBuilder(
            new SingleContextByName('name', $this->createMock(GameContext::class))
        );
    }

    public function test_it_should_replace_context(): void
    {
        $engine = new GameEngine();
        $engine->addContextBuilder(
            new SingleContextByName('name', $original = $this->createMock(GameContext::class))
        );
        $this->assertSame($original, $engine->getContext('name'));

        $engine->updateContext('name', $new = $this->createMock(GameContext::class));

        $this->assertSame($new, $engine->getContext('name'));
    }

    public function test_it_should_throw_exception_when_context_not_set_on_replace(): void
    {
        $engine = new GameEngine();
        $this->assertFalse($engine->hasContext('name'));

        $this->expectException(GameContextNotFound::class);
        $this->expectExceptionMessage('The game context "name" could not be found.');
        $engine->updateContext('name', $this->createMock(GameContext::class));
    }

    public function test_it_should_dispatch_the_event_by_class_name(): void
    {
        $engine = new GameEngine();
        $dispatched = false;
        $event = $this->createMock(GameEvent::class);

        $engine->addPlugin($plugin = new CallbackPlugin([
            get_class($event) => function () use (&$dispatched) {
                $dispatched = true;
            },
        ]));

        $this->assertFalse($dispatched);

        $engine->dispatchEvent($event);

        $this->assertTrue($dispatched);
    }

    public function test_it_should_dispatch_command_to_handler(): void
    {
        $engine = new GameEngine();
        $command = $this->createMock(GameCommand::class);

        $engine->addHandler(
            get_class($command),
            function () {
                throw new RuntimeException('My command was invoked.');
            }
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('My command was invoked.');
        $engine->dispatchCommand($command);
    }

    public function test_it_should_throw_exception_when_no_handler_for_command(): void
    {
        $engine = new GameEngine();
        $this->expectException(HandlerNotFound::class);
        $this->expectExceptionMessage('No command handler was found for command "Mock_GameCommand_');
        $engine->dispatchCommand($this->createMock(GameCommand::class));
    }

    public function test_it_should_call_listeners_on_same_event_based_on_priority(): void
    {
        $engine = new GameEngine();
        $event = new EventSpy('event');
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event) {
                $event->addPayload('normal');
            },
            500
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event) {
                $event->addPayload('fast');
            },
            700
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event) {
                $event->addPayload('very slow');
            },
            100
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event) {
                $event->addPayload('very fast');
            },
            900
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event) {
                $event->addPayload('slow');
            },
            300
        );

        $this->assertSame(
            [
                'event occurred.',
            ],
            $event->payload()
        );

        $engine->dispatchEvent($event);

        $this->assertSame(
            [
                'event occurred.',
                'very fast',
                'fast',
                'normal',
                'slow',
                'very slow',
                'event occurred.',
            ],
            $event->payload()
        );
    }

    public function test_it_should_throw_exception_when_two_listener_of_same_event_registered_with_same_priority(): void
    {
        $engine = new GameEngine();
        $engine->addListener('event', function () {}, 50);

        $this->expectException(DuplicatePriorityForEventListener::class);
        $this->expectExceptionMessage(
            'The listeners "Closure, Closure" on event "event" are registered with duplicated priority "50".'
        );
        $engine->addListener('event', function () {}, 50);
    }

    public function test_it_should_visit_plugin(): void
    {
        $visitor = $this->createMock(GameVisitor::class);
        $visitor->expects($this->once())->method('visitPlugin');

        $engine = new GameEngine();
        $engine->addPlugin($this->createMock(GamePlugin::class));
        $engine->acceptGameVisitor($visitor);
    }

    public function test_it_should_visit_command_handlers(): void
    {
        $visitor = $this->createMock(GameVisitor::class);
        $visitor
            ->expects($this->once())
            ->method('visitCommandHandler');

        $engine = new GameEngine();
        $engine->addHandler('command_name', function () {});
        $engine->acceptGameVisitor($visitor);
    }

    public function test_it_should_pass_the_engine_to_listeners(): void
    {
        $engine = new GameEngine();
        $listener = new class() {
            public $invoked = false;
            public $engine;
            public $dispatcher;
            public function __invoke()
            {
                $this->invoked = true;
                $this->engine = func_get_args()[1];
                $this->dispatcher = func_get_args()[2];
            }
        };
        $engine->addListener(EventOccurred::class, $listener, 500);

        $this->assertFalse($listener->invoked);
        $this->assertNull($listener->engine);
        $this->assertNull($listener->dispatcher);

        $engine->dispatchEvent(new EventOccurred('e'));

        $this->assertTrue($listener->invoked);
        $this->assertSame($engine, $listener->engine);
        $this->assertInstanceOf(EventDispatcherInterface::class, $listener->dispatcher);
    }

    public function test_it_should_trigger_event_before_dispatching_command(): void
    {
        $engine = new GameEngine();
        $engine->addListener(
            GameEngineEvents::GAME_AFTER_COMMAND,
            function () {
                $this->fail('Event should not have been triggered');
            },
            50
        );
        $engine->addListener(
            GameEngineEvents::GAME_BEFORE_COMMAND,
            function () {
                throw new RuntimeException('Before event triggered');
            },
            50
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Before event triggered');
        $engine->dispatchCommand(new DoGameCommand());
    }

    public function test_it_should_throw_exception_when_duplicate_listener_for_same_event_registered(): void
    {
        $engine = new GameEngine();
        $listener = new class {
            public function __invoke()
            {
                throw new RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
            }
        };
        $engine->addListener('event', $listener, 1);

        $this->expectException(DuplicateListenerForEvent::class);
        $this->expectExceptionMessage(
            sprintf(
                'Listener "%s" was already registered for event "event".', get_class($listener)
            )
        );
        $engine->addListener('event', $listener, 5);
    }

    public function test_it_should_handle_query_dispatching(): void
    {
        $query = $this->createMock(GameQuery::class);

        $engine = new GameEngine();
        $engine->addHandler(
            get_class($query),
            function (): QueryResult {
                return $this->createMock(QueryResult::class);
            }
        );
        $this->assertInstanceOf(QueryResult::class, $engine->dispatchQuery($query));
    }
}
