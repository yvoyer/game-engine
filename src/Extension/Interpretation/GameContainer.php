<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

final class GameContainer
{
    private const NAMESPACE_FUNCTION = '__FUNCTION__';

    /**
     * @var callable[]|GameFunction[]
     */
    private $items = [];

    public function addFunction(GameFunction $function): void
    {
        // todo throw exception when duplicate
        $this->items[self::NAMESPACE_FUNCTION . $function->getName()] = $function;
    }

    public function addTrigger(GameTrigger $trigger): void
    {

    }

    public function addConstant(GameConstant $constant): void
    {

    }

    public function findFunction(string $name): GameFunction
    {
        return $this->items[self::NAMESPACE_FUNCTION . $name];
    }

    public function createExtension(): GameExtension
    {
        $extension = new GameExtension($this);
        // todo build

        return $extension;
    }
}
