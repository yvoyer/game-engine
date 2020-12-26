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
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\Queries\QueryResult;
use Star\GameEngine\Testing\Stub\DoGameCommand;
use Star\GameEngine\Testing\Stub\EventOccurred;
use Star\GameEngine\Testing\Stub\EventSpy;
use Star\GameEngine\Testing\Stub\ListenerStub;
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
                    EventOccurred::class => function () use (&$dispatched): void {
                        $dispatched = true;
                    },
                ]
            )
        );

        self::assertFalse($dispatched);

        $engine->dispatchEvent(new EventOccurred('event'));

        self::assertTrue($dispatched);
    }

    public function test_command_should_be_dispatched(): void
    {
        $engine = new GameEngine();
        $dispatched = false;
        $engine->addPlugin(
            $plugin = new CallbackPlugin(
                [],
                [
                    DoGameCommand::class => function () use (&$dispatched): void {
                        $dispatched = true;
                    },
                ]
            )
        );

        self::assertFalse($dispatched);

        $engine->dispatchCommand(new DoGameCommand());

        self::assertTrue($dispatched);
    }

    public function test_it_should_return_the_context(): void
    {
        $engine = new GameEngine();
        self::assertFalse($engine->hasContext('name'));

        $engine->addContextBuilder(
            new SingleContextByName('name', $expected = $this->createMock(GameContext::class))
        );

        self::assertTrue($engine->hasContext('name'));
        self::assertSame($expected, $engine->getContext('name'));
    }

    public function test_it_should_throw_exception_when_context_not_found(): void
    {
        $engine = new GameEngine();
        self::assertFalse($engine->hasContext('not-found'));

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
        self::assertTrue($engine->hasContext('name'));

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
        self::assertSame($original, $engine->getContext('name'));

        $engine->updateContext('name', $new = $this->createMock(GameContext::class));

        self::assertSame($new, $engine->getContext('name'));
    }

    public function test_it_should_throw_exception_when_context_not_set_on_replace(): void
    {
        $engine = new GameEngine();
        self::assertFalse($engine->hasContext('name'));

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
            get_class($event) => function () use (&$dispatched): void {
                $dispatched = true;
            },
        ]));

        self::assertFalse($dispatched);

        $engine->dispatchEvent($event);

        self::assertTrue($dispatched);
    }

    public function test_it_should_dispatch_command_to_handler(): void
    {
        $engine = new GameEngine();
        $command = $this->createMock(GameCommand::class);

        $engine->addHandler(
            get_class($command),
            function (): void {
                throw new RuntimeException('My command was invoked.');
            }
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('My command was invoked.');
        $engine->dispatchCommand($command);
    }

    public function test_it_should_call_listeners_on_same_event_based_on_priority(): void
    {
        $engine = new GameEngine();
        $event = new EventSpy('event');
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event): void {
                $event->addPayload('normal');
            },
            500
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event): void {
                $event->addPayload('fast');
            },
            700
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event): void {
                $event->addPayload('very slow');
            },
            100
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event): void {
                $event->addPayload('very fast');
            },
            900
        );
        $engine->addListener(
            EventSpy::class,
            function (EventSpy $event): void {
                $event->addPayload('slow');
            },
            300
        );

        self::assertSame(
            [
                'event occurred.',
            ],
            $event->payload()
        );

        $engine->dispatchEvent($event);

        self::assertSame(
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
        $engine->addListener('event', new ListenerStub(), 50);

        $this->expectException(DuplicatePriorityForEventListener::class);
        $this->expectExceptionMessage(
            'The listeners "AnonymousClosure, ListenerStub" on event "event" are '
            . 'registered with duplicated priority "50".'
        );
        $engine->addListener('event', function (): void {
        }, 50);
    }

    public function test_it_should_visit_plugin(): void
    {
        $visitor = $this->createMock(GameVisitor::class);
        $visitor->expects(self::once())->method('visitPlugin');

        $engine = new GameEngine();
        $engine->addPlugin($this->createMock(GamePlugin::class));
        $engine->acceptGameVisitor($visitor);
    }

    public function test_it_should_visit_command_handlers(): void
    {
        $visitor = $this->createMock(GameVisitor::class);
        $visitor
            ->expects(self::once())
            ->method('visitCommandHandler');

        $engine = new GameEngine();
        $engine->addHandler('command_name', function (): void {
        });
        $engine->acceptGameVisitor($visitor);
    }

    public function test_it_should_pass_the_engine_to_listeners(): void
    {
        $engine = new GameEngine();
        $listener = new class() {
            /**
             * @var bool
             */
            public $invoked = false;

            /**
             * @var Engine|null
             */
            public $engine;

            /**
             * @var EventDispatcherInterface|null
             */
            public $dispatcher;
            public function __invoke(): void
            {
                $this->invoked = true;
                $this->engine = func_get_args()[1];
                $this->dispatcher = func_get_args()[2];
            }
        };
        $engine->addListener(EventOccurred::class, $listener, 500);

        self::assertFalse($listener->invoked);
        self::assertNull($listener->engine);
        self::assertNull($listener->dispatcher);

        $engine->dispatchEvent(new EventOccurred('e'));

        self::assertTrue($listener->invoked);
        self::assertInstanceOf(Engine::class, $listener->engine);
        self::assertInstanceOf(EventDispatcherInterface::class, $listener->dispatcher);
    }

    public function test_it_should_throw_exception_when_duplicate_listener_for_same_event_registered(): void
    {
        $engine = new GameEngine();
        $listener = new class {
            public function __invoke(): void
            {
                throw new RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
            }
        };
        $engine->addListener('event', $listener, 1);

        $this->expectException(DuplicateListenerForEvent::class);
        $this->expectExceptionMessage(
            sprintf(
                'Listener "%s" was already registered for event "event".',
                get_class($listener)
            )
        );
        $engine->addListener('event', $listener, 5);
    }

    public function test_it_should_handle_query_dispatching(): void
    {
        $query = $this->createMock(GameQuery::class);
        $expected = $this->createMock(QueryResult::class);

        $engine = new GameEngine();
        $engine->addHandler(
            get_class($query),
            function () use ($expected) : QueryResult {
                return $expected;
            }
        );
        self::assertSame($expected, $engine->dispatchQuery($query));
    }
}
