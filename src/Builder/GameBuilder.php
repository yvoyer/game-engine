<?php declare(strict_types=1);

namespace Star\GameEngine\Builder;

use Star\GameEngine\Engine;
use Star\GameEngine\Extension\Interpretation\CallableFunction;
use Star\GameEngine\Extension\Interpretation\Constant\StringConstant;
use Star\GameEngine\Extension\Interpretation\GameContainer;
use Star\GameEngine\Extension\Interpretation\InterpreterPlugin;
use Star\GameEngine\Extension\Interpretation\Trigger\ConditionParser;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerParser;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerReference;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerDescription;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerFrequency;
use Star\GameEngine\GameEngine;

final class GameBuilder
{
    /**
     * @var GameContainer
     */
    private $container;

    private function __construct()
    {
        $this->container = new GameContainer();
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

    public function addTrigger(
        string $condition,
        string $effect,
        int $frequency,
        string $description
    ): self {
        $this->container->addTrigger(
            new TriggerReference(
                ConditionParser::fromString($condition),
                TriggerParser::fromString($effect),
                TriggerFrequency::fromInt($frequency),
                TriggerDescription::fromString($description)
            )
        );

        return $this;
    }

    public function createGame(): Engine
    {
        $engine = new GameEngine();
        $engine->addPlugin(new InterpreterPlugin($this->container));

        return $engine;
    }

    public static function newGame(string $name): GameBuilder
    {
        return new self();
    }
}
