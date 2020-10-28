<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

final class ArrayMapContext implements GameContext, ContextRegistry
{
    /**
     * @var GameContext[]
     */
    private $contexts = [];

    public function addContextBuilder(ContextBuilder $builder): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    public function hasContext(string $name): bool
    {
        return \array_key_exists($name, $this->contexts);
    }

    public function getContext(string $name): GameContext
    {
        if (! $this->hasContext($name)) {
            throw new GameContextNotFound($name);
        }

        return $this->contexts[$name];
    }

    public function updateContext(string $name, GameContext $context): void
    {
        $this->contexts[$name] = $context;
    }
}
