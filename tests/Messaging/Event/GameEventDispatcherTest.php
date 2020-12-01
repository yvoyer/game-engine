<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Star\GameEngine\Engine;
use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\GameCommand;

final class GameEventDispatcherTest extends TestCase
{
    public function test_it_should_call_observer_when_dispatching(): void
    {
        $observer = $this->createMock(EngineObserver::class);
        $observer
            ->expects($this->once())
            ->method('notifyListenerDispatch');

        $engine = $this->createMock(Engine::class);

        $dispatcher = new GameEventDispatcher($engine);
        $dispatcher->addObserver($observer);
        $dispatcher->addListener('event', function () {
        });

        $dispatcher->dispatch($this->createMock(GameEvent::class), 'event');
    }

    public function test_it_should_throw_exception_when_invalid_event_given(): void
    {
        $dispatcher = new GameEventDispatcher($this->createMock(Engine::class));
        $dispatcher->addListener('stdClass', function () {
        });

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'Event "stdClass" is not an instance of "Star\GameEngine\Messaging\Event\GameEvent".'
        );
        $dispatcher->dispatch((object) []);
    }

    public function test_it_should_notify_observers_when_command_scheduled(): void
    {
        $dispatcher = new GameEventDispatcher($this->createMock(Engine::class));
        $observer = $this->createMock(EngineObserver::class);
        $observer
            ->expects($this->once())
            ->method('notifyScheduleCommand');
        $dispatcher->addObserver($observer);

        $dispatcher->notifyScheduleCommand($this->createMock(GameCommand::class));
    }
}
