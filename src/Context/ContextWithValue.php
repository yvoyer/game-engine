<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

final class ContextWithValue implements ContextBuilder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var GameContext
     */
    private $value;

    public function __construct(string $name, GameContext $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function create(ContextRegistry $registry): ContextRegistry
    {
        $registry->updateContext($this->name, $this->value);

        return $registry;
    }
}
