<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use Assert\Assertion;
use Star\GameEngine\Component\Card\Prototyping\Value\ArrayOfValues;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;
use function sprintf;

/**
 * Class responsible of dispatching to the correct ChoicesOf<Type>Type class, based on the content of authorized values.
 */
final class ChoicesOfMixedType implements VariableType
{
    /**
     * @var ArrayOfValues
     */
    private $authorizedOptions;

    /**
     * @var VariableType
     */
    private $typeOfOptions;

    public function __construct(ArrayOfValues $authorizedOptions)
    {
        $this->authorizedOptions = $authorizedOptions;

        $this->typeOfOptions = new ChoicesOfStringType();
    }

    /**
     * @param ArrayOfValues $value
     * @return VariableValue
     * @throws \Assert\AssertionFailedException
     */
    public function createValueFromMixed($value): VariableValue
    {
        Assertion::isInstanceOf($value, ArrayOfValues::class);
        if (! $this->authorizedOptions->contains($value)) {
            throw new InvalidAuthorizedChoices(
                sprintf(
                    'Some values in "%s" are not in the authorized values "%s".',
                    $value->toTypedString(),
                    $this->authorizedOptions->toTypedString()
                )
            );
        }

        return $value;
    }
}
