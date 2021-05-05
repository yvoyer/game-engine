<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Star\GameEngine\Component\Card\CardVisitor;

interface VariableValue
{
    public function acceptCardVisitor(string $name, CardVisitor $visitor): void;
    public function toTypedString(): string;
}
