<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Reading;

use Star\GameEngine\Component\Card\CardVisitor;
use Star\GameEngine\Component\Card\Prototyping\CardBehavior;
use Star\GameEngine\Component\Card\Prototyping\Value\StringValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

final class CardReader implements CardVisitor
{
    /**
     * @var VariableValue[]
     */
    private $values = [];

    /**
     * @var CardBehavior
     */
    private $behaviors = [];

    /**
     * @return VariableValue[]
     */
    public function getVariables(): array
    {
        return $this->values;
    }

    /**
     * @return CardBehavior[]
     */
    public function getBehaviors(): array
    {
        return $this->behaviors;
    }

    public function visitTextVariable(string $name, StringValue $value): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function visitBehavior(CardBehavior $behavior): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
