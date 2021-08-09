<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Assert\Assertion;
use Star\GameEngine\Component\Card\CardBuilder;
use Star\GameEngine\Component\Card\Prototyping\Value\IntegerValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

/**
 * @internal This class is internal to the CardBuilder class.
 * @see CardBuilder
 */
final class IntegerType implements VariableType
{
    public function createValueFromMixed($value): VariableValue
    {
        if ($value instanceof IntegerValue) {
            $value = $value->toString();
        }
        Assertion::integerish($value);

        return IntegerValue::fromInt((int) $value);
    }
}
