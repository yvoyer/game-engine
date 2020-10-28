<?php declare(strict_types=1);

namespace Star\GameEngine\Adapters;

use Star\Component\DomainEvent\DomainEvent;
use Star\Component\DomainEvent\EventListener;
use Star\Component\DomainEvent\EventPublisher;
use Star\GameEngine\Engine;

final class EnginePublisher implements EventPublisher
{
    /**
     * @var Engine
     */
    private $engine;

    public function __construct(Engine $engine)
    {
        $this->engine = $engine;
    }

    public function subscribe(EventListener $listener): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function publish(DomainEvent $event): void
    {
        $this->engine->dispatchEvent($event);
    }

    public function publishChanges(array $events): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
