<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

final class SingleContextByName implements ContextBuilder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var GameContext
     */
    private $context;

    public function __construct(string $name, GameContext $context)
    {
        $this->name = $name;
        $this->context = $context;
    }

    public function create(ContextRegistry $registry): ContextRegistry
    {
        if ($registry->hasContext($this->name)) {
            throw new DuplicatedGameContext($this->name);
        }

        $registry->updateContext($this->name, $this->context);

        return $registry;
    }
}
