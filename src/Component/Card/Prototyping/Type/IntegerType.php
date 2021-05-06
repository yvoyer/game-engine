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
        Assertion::integerish($value);

        return $this->createValueFromInteger((int) $value);
    }

    public function createValueFromString(string $value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function createValueFromInteger(int $value): VariableValue
    {
        return IntegerValue::fromInt($value);
    }

    public function createValueFromBoolean(bool $value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
