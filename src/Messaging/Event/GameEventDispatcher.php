<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

use InvalidArgumentException;
use Star\GameEngine\Engine;
use Star\GameEngine\GameVisitor;
use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\ObserverIterator;
use Symfony\Component\EventDispatcher\EventDispatcher;
use function get_class;
use function sprintf;

final class GameEventDispatcher extends EventDispatcher
{
    /**
     * @var Engine
     */
    private $engine;

    /**
     * @var ObserverIterator
     */
    private $observer;

    public function __construct(Engine $engine)
    {
        parent::__construct();
        $this->engine = $engine;
        $this->observer = new ObserverIterator();
    }

    protected function callListeners(iterable $listeners, string $eventName, object $event): void
    {
        if (! $event instanceof GameEvent) {
            throw new InvalidArgumentException(
                sprintf('Event "%s" is not an instance of "%s".', get_class($event), GameEvent::class)
            );
        }

        foreach ($listeners as $listener) {
            if ($event->isPropagationStopped()) {
                break;
            }

            // Cannot use event system, since we would get infinite recursion
            $this->observer->notifyListenerDispatch($listener, $event);

            $listener($event, $this->engine, $this);
        }
    }

    public function acceptGameVisitor(GameVisitor $visitor): void
    {
        foreach ($this->getListeners() as $event => $listeners) {
            foreach ($listeners as $listener) {
                $visitor->visitListener($event, get_class($listener));
            }
        }
    }

    public function addObserver(EngineObserver $observer): void
    {
        $this->observer->addObserver($observer);
    }

    public function notifyScheduleCommand(GameCommand $command): void
    {
        $this->observer->notifyScheduleCommand($command);
    }
}
