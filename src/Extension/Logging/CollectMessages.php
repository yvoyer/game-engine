<?php declare(strict_types=1);

namespace Star\Component\GameEngine\Extension\Logging;

use Star\GameEngine\Messaging\EngineObserver;
use Symfony\Contracts\EventDispatcher\Event;

final class CollectMessages implements EngineObserver
{
    public function notifyListenerDispatch(callable $listener, Event $event): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
