<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Star\GameEngine\Messaging\Event\GameEvent;

interface EngineObserver
{
    public function notifyScheduleCommand(GameCommand $command): void;

    public function notifyListenerDispatch(callable $listener, GameEvent $event): void;
}
