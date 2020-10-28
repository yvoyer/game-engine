<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\GameVisitor;

final class ListenerPriorityTree implements GameVisitor
{
    /**
     * @var string[]
     */
    private $handlers = [];

    /**
     * @var string[][]
     */
    private $listeners = [];

    public function getHandlerStructure(): array
    {
        return $this->handlers;
    }

    public function getListenerStructure(): array
    {
        return $this->listeners;
    }

    public function visitPlugin(GamePlugin $plugin): void
    {
        // do nothing
    }

    public function visitCommandHandler(string $command, callable $handler): void
    {
        $this->handlers[$command] = $handler;
    }

    public function visitQueryHandler(string $query, callable $handler): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function visitListener(string $event, string $listener): void
    {
        $this->listeners[$event][] = $listener;
    }
}
