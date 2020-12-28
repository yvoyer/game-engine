<?php declare(strict_types=1);

namespace Star\GameEngine\Builder;

use Star\GameEngine\Engine;
use Star\GameEngine\Extension\Interpretation\CallableFunction;
use Star\GameEngine\Extension\Interpretation\Constant\StringConstant;
use Star\GameEngine\Extension\Interpretation\Effect\DispatchFunction;
use Star\GameEngine\Extension\Interpretation\GameExtension;
use Star\GameEngine\Extension\Interpretation\InterpreterPlugin;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerCondition;
use Star\GameEngine\Extension\Interpretation\Trigger\GameTrigger;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerDescription;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerFrequency;
use Star\GameEngine\GameEngine;
use function array_filter;

final class GameBuilder
{
    /**
     * @var GameExtension
     */
    private $container;

    /**
     * @var TriggerFrequency[]
     */
    private $frequencies = [];

    private function __construct()
    {
        $this->container = new GameExtension();
    }

    public function addConstant(string $name, string $value): self
    {
        $this->container->addConstant(new StringConstant($name, $value));

        return $this;
    }

    public function addFunction(string $name, callable $handler): self
    {
        $this->container->addFunction(new CallableFunction($name, $handler));

        return $this;
    }

    public function addFrequency(int $identifier, string $event): self
    {
        $this->frequencies[$identifier] = new TriggerFrequency($event);

        return $this;
    }

    public function addTrigger(
        string $condition,
        string $effect,
        int $frequencyIds,
        string $description
    ): self {
        $frequencies = $this->findAllFrequencies($frequencyIds);
        foreach ($frequencies as $frequency) {
            $this->container->addTrigger(
                new GameTrigger(
                    new TriggerCondition($condition),
                    new DispatchFunction($effect),
                    $frequency,
                    TriggerDescription::fromString($description)
                )
            );
        }

        return $this;
    }

    public function buildGame(): Engine
    {
        $engine = new GameEngine();
        $engine->addPlugin(new InterpreterPlugin($this->container));

        return $engine;
    }

    /**
     * @param int $ids
     * @return TriggerFrequency[]
     */
    private function findAllFrequencies(int $ids): array
    {
        return array_filter(
            $this->frequencies,
            function (int $key) use ($ids): bool {
                return ($ids & $key) === $key;
            },
            ARRAY_FILTER_USE_KEY
        );
    }

    public static function newGame(string $name): GameBuilder
    {
        return new self();
    }
}
