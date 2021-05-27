<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Assert\Assertion;
use Generator;
use Star\GameEngine\Component\Card\CardVisitor;
use Star\GameEngine\Component\Card\Prototyping\Type\InvalidAuthorizedChoices;
use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;
use function array_map;
use function array_merge;
use function get_class;
use function gettype;
use function implode;
use function sprintf;

final class ArrayOfValues implements VariableValue
{
    /**
     * @var VariableValue[]
     */
    private $choices;

    /**
     * @var null|array
     */
    private $cached_map;

    private function __construct(VariableValue ...$choices)
    {
        $this->choices = $choices;
    }

    public function acceptCardVisitor(string $name, CardVisitor $visitor): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function acceptValueVisitor(ValueVisitor $visitor): void
    {
        $visitor->enterChoiceValue();
        foreach ($this->choices as $choice) {
            $choice->acceptValueVisitor($visitor);
        }
        $visitor->exitChoiceValue();
    }

    public function isList(): bool
    {
        return true;
    }

    public function toList(): array
    {
        $this->acceptValueVisitor($visitor = new class implements ValueVisitor {
            public $values = [];

            public function visitBooleanValue(bool $value): void
            {
                $this->values[] = $value;
            }

            public function visitStringValue(string $value): void
            {
                $this->values[] = $value;
            }

            public function visitIntegerValue(int $value): void
            {
                $this->values[] = $value;
            }

            public function visitFloatValue(): void
            {
                throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
            }

            public function enterChoiceValue(): void
            {
            }

            public function exitChoiceValue(): void
            {
            }
        });

        return $visitor->values;
    }

    public function toTypedString(): string
    {
        return sprintf('choice(%s)', $this->toString());
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

    public function contains(ArrayOfValues $value): bool
    {
        return \count(
            \array_diff($value->comparableArray(), $this->comparableArray())
        ) === 0;
    }

    private function comparableArray(): array {
        if (! $this->cached_map) {
            $this->cached_map = [];
            foreach ($this->choices as $value) {
                $this->cached_map[] = $value->toString();
            }
        }

        return $this->cached_map;
    }

    public function buildVariable(VariableBuilder $builder, ArrayOfValues $selected): VariableValue
    {
        \var_dump($selected);
#        $builder->integerVariable()
    }

    private function toScalar(): array
    {
        return array_map(
            function (VariableValue $value): string {
                return $value->toString();
            },
            $this->choices
        );
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
                Assertion::allString($choices, 'Value "%s" expected to be string, type %s given.');
                return self::arrayOfStrings(...$choices);

            case 'integer':
                Assertion::allInteger($choices, 'Value "%s" expected to be integer, type %s given.');
                return self::arrayOfIntegers(...$choices);

            case 'double':
                Assertion::allFloat($choices, 'Value "%s" expected to be float, type %s given.');
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
