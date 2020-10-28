<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

final class NoContext implements ContextBuilder
{
    public function create(ContextRegistry $registry): ContextRegistry
    {
        return $registry;
    }
}
