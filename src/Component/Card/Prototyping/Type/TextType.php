<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Star\GameEngine\Component\Card\Prototyping\Value\StringValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

final class TextType implements VariableType
{
    public function stringToVariableValue(string $value): VariableValue
    {
        return StringValue::fromString($value);
    }
}
