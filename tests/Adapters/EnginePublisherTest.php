<?php declare(strict_types=1);

namespace Star\GameEngine\Adapters;

use PHPUnit\Framework\TestCase;
use Star\Component\DomainEvent\EventListener;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Testing\Stub\EngineSpy;

final class EnginePublisherTest extends TestCase
{
    public function test_it_should_register_listener(): void
    {
        $publisher = new EnginePublisher($spy = new EngineSpy());
        self::assertCount(0, $spy->listeners);

        $listener = $this->createMock(EventListener::class);
        $listener
            ->method('listensTo')
            ->willReturn(['event' => 'onEvent']);

        $publisher->subscribe($listener);

        self::assertCount(1, $spy->listeners);
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
}
