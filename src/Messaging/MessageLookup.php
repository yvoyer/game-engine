<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\GameVisitor;
use function array_search;

final class MessageLookup implements GameVisitor
{
    /**
     * @var string[]
     */
    private $messages = [];

    public function isRegistered(string $message): bool
    {
        return false !== array_search($message, $this->messages, true);
    }

    public function visitPlugin(GamePlugin $plugin): void
    {
    }

    public function visitCommandHandler(string $command, callable $handler): void
    {
        $this->messages[] = $command;
    }

    public function visitQueryHandler(string $query, callable $handler): void
    {
        $this->messages[] = $query;
    }

    public function visitListener(string $event, string $listener): void
    {
        $this->messages[] = $event;
    }
}
