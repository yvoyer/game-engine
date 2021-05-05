<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping;

use Star\GameEngine\Component\Card\CardVisitor;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

/**
 * Object that represents the property of a card that may change during a game.
 * The property do not have any special effect on the game, it is meant to
 * keep track of a value for behaviors.
 *
 * @see CardBehavior
 */
final class CardVariable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var VariableValue
     */
    private $value;

    public function __construct(string $name, VariableValue $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): VariableValue
    {
        return $this->value;
    }

    public function acceptCardVisitor(CardVisitor $visitor): void
    {
        $this->value->acceptCardVisitor($this->name, $visitor);
    }
}
