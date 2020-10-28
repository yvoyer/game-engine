<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

use Psr\EventDispatcher\StoppableEventInterface;
use Star\GameEngine\Engine;
use Star\GameEngine\GameVisitor;
use Star\GameEngine\Messaging\EngineObserver;
use Symfony\Component\EventDispatcher\EventDispatcher;
use function get_class;

final class GameEventDispatcher extends EventDispatcher
{
    /**
     * @var Engine
     */
    private $engine;

    /**
     * @var EngineObserver
     */
    private $observer;

    public function __construct(Engine $engine, EngineObserver $observer)
    {
        parent::__construct();
        $this->engine = $engine;
        $this->observer = $observer;
    }

    protected function callListeners(iterable $listeners, string $eventName, object $event)
    {
        foreach ($listeners as $listener) {
            if ($event instanceof StoppableEventInterface && $event->isPropagationStopped()) {
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
}
