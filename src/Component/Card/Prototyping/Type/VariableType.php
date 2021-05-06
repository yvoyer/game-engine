<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

interface VariableType
{
    public function createValueFromMixed($value): VariableValue;
    public function createValueFromString(string $value): VariableValue;
    public function createValueFromInteger(int $value): VariableValue;
    public function createValueFromBoolean(bool $value): VariableValue;
}
