<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Star\GameEngine\Component\Card\Prototyping\Value\BooleanValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

final class BooleanType implements VariableType
{
    public function createValueFromMixed($value): VariableValue
    {
        if ($value instanceof BooleanValue) {
            return $value;
        }

        return BooleanValue::fromBoolean($value);
    }
}
