<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping;

use Star\GameEngine\Component\Card\Prototyping\Type;
use Star\GameEngine\Component\Card\Prototyping\Value\ChoiceValue;

/**
 * @api
 */
final class VariableBuilder
{
    public function textVariable(string $name, string $value): CardVariable
    {
        return new CardVariable($name, (new Type\StringType())->createValueFromMixed($value));
    }

    public function integerVariable(string $name, int $value): CardVariable
    {
        return new CardVariable($name, (new Type\IntegerType())->createValueFromInteger($value));
    }

    public function booleanVariable(string $name, bool $value): CardVariable
    {
        return new CardVariable($name, (new Type\BooleanType())->createValueFromBoolean($value));
    }

    public function choicesVariable(
        string $name,
        ChoiceValue $selectedOptions,
        ChoiceValue $authorizedValues
    ): CardVariable {
        return new CardVariable(
            $name,
            (new Type\ChoicesOfMixedType($authorizedValues))->createValueFromMixed($selectedOptions)
        );
    }
}
