<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Star\GameEngine\Messaging\Event\GameEvent;
use function array_map;

final class ObserverIterator implements EngineObserver
{
    /**
     * @var EngineObserver[]
     */
    private $observers = [];

    public function __construct(EngineObserver ...$observers)
    {
        array_map(
            function (EngineObserver $observer): void {
                $this->addObserver($observer);
            },
            $observers
        );
    }

    public function addObserver(EngineObserver $observer): void
    {
        $this->observers[] = $observer;
    }

    public function notifyScheduleCommand(GameCommand $command): void
    {
        foreach ($this->observers as $observer) {
            $observer->notifyScheduleCommand($command);
        }
    }

    public function notifyListenerDispatch(callable $listener, GameEvent $event): void
    {
        foreach ($this->observers as $observer) {
            $observer->notifyListenerDispatch($listener, $event);
        }
    }
}
