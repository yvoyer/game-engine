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
        return $this->createValueFromString($value);
    }

    public function createValueFromString(string $value): VariableValue
    {
        return StringValue::fromString($value);
    }

    public function createValueFromInteger(int $value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function createValueFromBoolean(bool $value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
