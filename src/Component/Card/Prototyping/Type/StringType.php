<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Star\GameEngine\Component\Card\Prototyping\Value\StringValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

/**
 * @internal This class is internal to the CardBuilder class.
 * @see CardBuilder
 */
final class StringType implements VariableType
{
    public function createValueFromMixed($value): VariableValue
    {
        if ($value instanceof StringValue) {
            return $value;
        }

        return StringValue::fromString($value);
    }
}
