<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

final class ChoicesOfFloatType implements VariableType
{
    public function createValueFromMixed($value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
