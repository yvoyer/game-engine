<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping;

use Star\GameEngine\Component\Card\Prototyping\Type;
use Star\GameEngine\Component\Card\Prototyping\Value\BooleanValue;
use Star\GameEngine\Component\Card\Prototyping\Value\ArrayOfValues;
use Star\GameEngine\Component\Card\Prototyping\Value\IntegerValue;
use Star\GameEngine\Component\Card\Prototyping\Value\StringValue;

/**
 * @api
 */
final class VariableBuilder
{
    public function textVariable(string $name, string $value): CardVariable
    {
        return new CardVariable($name, StringValue::fromString($value));
    }

    public function integerVariable(string $name, int $value): CardVariable
    {
        return new CardVariable($name, IntegerValue::fromInt($value));
    }

    public function booleanVariable(string $name, bool $value): CardVariable
    {
        return new CardVariable($name, BooleanValue::fromBoolean($value));
    }

    public function choicesVariable(
        string $name,
        ArrayOfValues $selectedOptions,
        ArrayOfValues $authorizedValues
    ): CardVariable {
        return new CardVariable(
            $name,
            (new Type\ChoicesOfMixedType($authorizedValues))->createValueFromMixed($selectedOptions)
        );
    }
}
