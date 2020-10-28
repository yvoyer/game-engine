<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

interface ContextRegistry
{
    public function hasContext(string $name): bool;

    public function getContext(string $name): GameContext;

    public function updateContext(string $name, GameContext $context): void;
}
