<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

interface Card
{
    public function isValid(ErrorReader $errors = null): bool;
    public function acceptCardVisitor(CardVisitor $visitor): void;
    public function getVariableValue(string $name): VariableValue;
}
