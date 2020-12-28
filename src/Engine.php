<?php declare(strict_types=1);

namespace Star\GameEngine;

use Star\GameEngine\Context\ContextBuilder;
use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\Queries\QueryResult;

interface Engine
{
    /**
     * Register a context builder
     *
     * @param ContextBuilder $builder
     */
    public function addContextBuilder(ContextBuilder $builder): void;

    /**
     * @param string $eventName The FQCN of a class implementing GameEvent
     * @param callable $callable
     * @param int $priority
     * @see GameEvent
     */
    public function addListener(string $eventName, callable $callable, int $priority): void;

    /**
     * @param string $message The FQCN of a message implementing GameMessage
     * @param callable $handler
     * @see GameMessage
     */
    public function addHandler(string $message, callable $handler): void;

    public function addPlugin(GamePlugin $plugin): void;

    public function addObserver(EngineObserver $observer): void;

    public function dispatchEvent(GameEvent ...$events): void;

    public function dispatchCommand(GameCommand $command): void;

    public function dispatchQuery(GameQuery $query): QueryResult;
}
