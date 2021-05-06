<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Star\GameEngine\Component\Card\Prototyping\Value\BooleanValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

final class BooleanType implements VariableType
{
    public function createValueFromMixed($value): VariableValue
    {
        return $this->createValueFromBoolean($value);
    }

    public function createValueFromString(string $value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function createValueFromInteger(int $value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function createValueFromBoolean(bool $value): VariableValue
    {
        return BooleanValue::fromBoolean($value);
    }
}
