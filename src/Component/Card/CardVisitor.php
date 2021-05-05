<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use Star\GameEngine\Component\Card\Prototyping\CardBehavior;
use Star\GameEngine\Component\Card\Prototyping\Value\StringValue;

interface CardVisitor
{
    public function visitTextVariable(string $name, StringValue $value): void;

    public function visitBehavior(CardBehavior $behavior): void;
}
