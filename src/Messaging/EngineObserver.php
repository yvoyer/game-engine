<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Symfony\Contracts\EventDispatcher\Event;

interface EngineObserver
{
    public function notifyListenerDispatch(callable $listener, Event $event): void;
}
