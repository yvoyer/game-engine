<?php declare(strict_types=1);

namespace Star\GameEngine;

use Star\GameEngine\Extension\GamePlugin;

interface GameVisitor
{
    public function visitPlugin(GamePlugin $plugin): void;
    public function visitCommandHandler(string $command, callable $handler): void;
    public function visitQueryHandler(string $query, callable $handler): void;
    public function visitListener(string $event, string $listener): void;
}
