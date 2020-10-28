<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Symfony\Contracts\EventDispatcher\Event;

final class ObserverIterator implements EngineObserver
{
    /**
     * @var EngineObserver[]
     */
    private $observers = [];

    public function __construct(EngineObserver ...$observers)
    {
        $this->observers = $observers;
    }

    public function addObserver(EngineObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function notifyListenerDispatch(callable $listener, Event $event): void
    {
        foreach ($this->observers as $observer) {
            $observer->notifyListenerDispatch($listener, $event);
        }
    }
}
