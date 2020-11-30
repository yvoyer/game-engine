<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Logging;

use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;

final class CollectMessages implements EngineObserver
{
    /**
     * @var string[]
     */
    private $messages = [];

    public function notifyListenerDispatch(callable $listener, GameEvent $event): void
    {
        $this->messages[] = $event->toString();
    }

    public function notifyScheduleCommand(GameCommand $command): void
    {
        $this->messages[] = $command->toString();
    }

    public function getMessages(): array {
        return $this->messages;
    }
}
