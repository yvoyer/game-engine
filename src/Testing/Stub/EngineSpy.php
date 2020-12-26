<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Stub;

use RuntimeException;
use Star\Component\DomainEvent\DomainEvent;
use Star\GameEngine\Context\ContextBuilder;
use Star\GameEngine\Engine;
use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\Queries\QueryResult;
use function array_merge;

final class EngineSpy implements Engine
{
    /**
     * @var callable[]
     */
    public $listeners = [];

    /**
     * @var DomainEvent[]
     */
    public $publishedEvents = [];

    /**
     * @var callable[]
     */
    public $handlers = [];

    public function addContextBuilder(ContextBuilder $builder): void
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function addListener(string $eventName, callable $callable, int $priority): void
    {
        $this->listeners[$eventName] = $callable;
    }

    public function addHandler(string $message, callable $handler): void
    {
        $this->handlers[$message] = $handler;
    }

    public function addPlugin(GamePlugin $plugin): void
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function addObserver(EngineObserver $observer): void
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function dispatchEvent(GameEvent ...$events): void
    {
        $this->publishedEvents = array_merge($this->publishedEvents, $events);
    }

    public function dispatchCommand(GameCommand $command): void
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function dispatchQuery(GameQuery $query): QueryResult
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
