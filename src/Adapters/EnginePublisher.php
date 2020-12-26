<?php declare(strict_types=1);

namespace Star\GameEngine\Adapters;

use InvalidArgumentException;
use RuntimeException;
use Star\Component\DomainEvent\DomainEvent;
use Star\Component\DomainEvent\EventListener;
use Star\Component\DomainEvent\EventPublisher;
use Star\GameEngine\Engine;
use Star\GameEngine\Messaging\Event\GameEvent;
use function get_class;
use function is_callable;
use function sprintf;

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
            $callback = [$listener, $method];
            if (! is_callable($callback)) {
                throw new RuntimeException(
                    sprintf('Method "%s" do not exists on listener "%s".', $method, get_class($listener))
                );
            }

            $this->engine->addListener($event, $callback, 0);
        }
    }

    public function publish(DomainEvent $event): void
    {
        if (! $event instanceof GameEvent) {
            throw new InvalidArgumentException(
                sprintf(
                    'Only GameEvent are supported for publishing, "%s" given.',
                    get_class($event)
                )
            );
        }

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
