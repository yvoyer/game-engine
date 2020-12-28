<?php declare(strict_types=1);

namespace Star\GameEngine\Adapters;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Star\Component\DomainEvent\DomainEvent;
use Star\Component\DomainEvent\EventListener;
use Star\GameEngine\Engine;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Testing\Stub\EngineSpy;

final class EnginePublisherTest extends TestCase
{
    public function test_it_should_register_listener(): void
    {
        $publisher = new EnginePublisher($spy = new EngineSpy());
        self::assertCount(0, $spy->listeners);

        $listener = new StubListener();

        $publisher->subscribe($listener);

        self::assertCount(1, $spy->listeners);
    }

    public function test_it_should_throw_exception_when_method_do_not_exists(): void
    {
        $publisher = new EnginePublisher($spy = new EngineSpy());
        $listener = $this->createMock(EventListener::class);
        $listener
            ->method('listensTo')
            ->willReturn(['event' => 'onEvent']);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Method "onEvent" do not exists on listener');
        $publisher->subscribe($listener);
    }

    public function test_it_should_publish_events(): void
    {
        $publisher = new EnginePublisher($spy = new EngineSpy());
        self::assertCount(0, $spy->publishedEvents);

        $publisher->publishChanges(
            [
                $this->createMock(GameEvent::class),
                $this->createMock(GameEvent::class),
                $this->createMock(GameEvent::class),
            ]
        );

        self::assertCount(3, $spy->publishedEvents);
    }

    public function test_it_should_throw_exception_when_event_is_not_game_event(): void
    {
        $publisher = new EnginePublisher($this->createMock(Engine::class));

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Only GameEvent are supported for publishing,');
        $publisher->publish($this->createMock(DomainEvent::class));
    }
}

final class StubListener implements EventListener
{
    public function onEvent(): void
    {
    }

    public function listensTo(): array
    {
        return ['event' => 'onEvent'];
    }
}
