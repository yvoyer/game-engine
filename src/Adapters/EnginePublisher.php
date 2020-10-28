<?php declare(strict_types=1);

namespace Star\GameEngine\Adapters;

use Star\Component\DomainEvent\DomainEvent;
use Star\Component\DomainEvent\EventListener;
use Star\Component\DomainEvent\EventPublisher;
use Star\GameEngine\Engine;
use function func_get_args;

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
        foreach ($listener->listensTo() as $event => $method) {
            $this->engine->addListener(
                $event,
                function () use ($listener, $method) {
                    return $listener->{$method}(...func_get_args());
                },
                0
            );
        }
    }

    public function publish(DomainEvent $event): void
    {
        $this->engine->dispatchEvent($event);
    }

    /**
     * @param DomainEvent[] $events
     */
    public function publishChanges(array $events): void
    {
        foreach ($events as $event) {
            $this->publish($event);
        }
    }
}
