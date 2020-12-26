<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

interface ContextBuilder
{
    public function create(ContextRegistry $registry): ContextRegistry;
}
