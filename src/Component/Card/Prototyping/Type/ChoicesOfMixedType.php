<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Star\GameEngine\Component\Card\Prototyping\Value\ChoiceValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;

/**
 * Class responsible of dispatching to the correct ChoicesOf<Type>Type class, based on the content of authorized values.
 */
final class ChoicesOfMixedType implements VariableType
{
    /**
     * @var ChoiceValue
     */
    private $authorizedOptions;

    /**
     * @var VariableType
     */
    private $typeOfOptions;

    public function __construct(ChoiceValue $authorizedOptions)
    {
        $this->authorizedOptions = $authorizedOptions;

        $this->typeOfOptions = new ChoicesOfStringType();
    }

    public function createValueFromMixed($value): VariableValue
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
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
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
