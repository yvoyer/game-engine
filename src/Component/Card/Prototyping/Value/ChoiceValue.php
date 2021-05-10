<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Star\GameEngine\Component\Card\CardVisitor;
use Star\GameEngine\Component\Card\Prototyping\Type\InvalidAuthorizedChoices;
use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;
use function array_map;
use function array_merge;
use function get_class;
use function gettype;
use function implode;
use function sprintf;

final class ChoiceValue implements VariableValue
{
    /**
     * @var VariableValue[]
     */
    private $choices;

    private function __construct(VariableValue ...$choices)
    {
        $this->choices = $choices;
    }

    public function acceptCardVisitor(string $name, CardVisitor $visitor): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function toTypedString(): string
    {
        return sprintf('array(%s)', $this->toString());
    }

    public function toString(): string
    {
        return implode(
            ';',
            array_map(
                function (VariableValue $value): string {
                    return $value->toString();
                },
                $this->choices
            )
        );
    }

    public function buildVariable(VariableBuilder $builder, ChoiceValue $selected): VariableValue
    {
        \var_dump($selected);
#        $builder->integerVariable()
    }

    public static function arrayOfIntegers(int $first, int ...$others): self
    {
        return new self(...
            array_map(
                function (int $value): IntegerValue {
                    return IntegerValue::fromInt($value);
                },
                array_merge([$first], $others)
            )
        );
    }

    public static function arrayOfFloats(float $first, float ...$others): self
    {
        return new self(...
            array_map(
                function (float $value): StringValue {
                    return StringValue::fromString((string) $value);
                },
                array_merge([$first], $others)
            )
        );
    }

    public static function arrayOfStrings(string $first, string ...$others): self
    {
        return new self(...
            array_map(
                function (string $value): StringValue {
                    return StringValue::fromString($value);
                },
                array_merge([$first], $others)
            )
        );
    }

    public static function arrayOfObjects(VariableValue $first, VariableValue ...$others): self
    {
        return new self(...array_merge([$first], $others));
    }

    public static function arrayOfUnknowns($first, ...$others): self
    {
        $choices = array_merge([$first], $others);
        $type = gettype($first);

        switch ($type) {
            case 'string':
                return self::arrayOfStrings(...$choices);

            case 'integer':
                return self::arrayOfIntegers(...$choices);

            case 'double':
                return self::arrayOfFloats(...$choices);
        }

        if ($type === 'object') {
            $type = get_class($first);
        }

        throw new InvalidAuthorizedChoices(
            sprintf('Choices with values of type "%s" are not supported yet.', $type)
        );
    }
}
