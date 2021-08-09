<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use Star\GameEngine\Component\Card\Prototyping\CardBehavior;
use Star\GameEngine\Component\Card\Prototyping\CardVariable;
use Star\GameEngine\Component\Card\Prototyping\MapOfBehaviors;
use Star\GameEngine\Component\Card\Prototyping\MapOfVariables;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\BooleanPlaceholder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\IntegerPlaceholder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\ChoicesPlaceholder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\PlaceholderBuilder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\PlaceholderData;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\TemplatePlaceholder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\StringPlaceholder;
use Star\GameEngine\Component\Card\Prototyping\Type\BooleanType;
use Star\GameEngine\Component\Card\Prototyping\Type\IntegerType;
use Star\GameEngine\Component\Card\Prototyping\Type\ChoicesOfMixedType;
use Star\GameEngine\Component\Card\Prototyping\Type\InvalidAuthorizedChoices;
use Star\GameEngine\Component\Card\Prototyping\Type\StringType;
use Star\GameEngine\Component\Card\Prototyping\Type\VariableType;
use Star\GameEngine\Component\Card\Prototyping\Value\BooleanValue;
use Star\GameEngine\Component\Card\Prototyping\Value\ArrayOfValues;
use Star\GameEngine\Component\Card\Prototyping\Value\IntegerValue;
use Star\GameEngine\Component\Card\Prototyping\Value\StringValue;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;
use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;
use function array_merge;

final class CardBuilder
{
    /**
     * @var CardVariable[]
     */
    private $variables = [];

    /**
     * @var StringPlaceholder[]
     */
    private $placeholders = [];

    /**
     * @var CardBehavior[]
     */
    private $behaviors = [];

    private function __construct()
    {
    }

    public function withTextPlaceholder(string $name): PlaceholderBuilder
    {
        return $this->withPlaceholder(new StringPlaceholder($name));
    }

    public function withIntegerPlaceholder(string $name): PlaceholderBuilder
    {
        return $this->withPlaceholder(new IntegerPlaceholder($name));
    }

    public function withBooleanPlaceholder(string $name): PlaceholderBuilder
    {
        return $this->withPlaceholder(new BooleanPlaceholder($name));
    }

    public function withChoicesPlaceholder(string $name, array $availableOptions): PlaceholderBuilder
    {
        return $this->withPlaceholder(
            new ChoicesPlaceholder($name, ArrayOfValues::arrayOfUnknowns(...$availableOptions))
        );
    }

    public function withPlaceholder(TemplatePlaceholder $placeholder): PlaceholderBuilder
    {
        $this->placeholders[] = $placeholder;

        return new PlaceholderBuilder($placeholder, $this);
    }

    public function withTextVariable(string $name, string $value): self
    {
        return $this->withVariable($name, new StringType(), StringValue::fromString($value));
    }

    public function withIntegerVariable(string $name, int $value): self
    {
        return $this->withVariable($name, new IntegerType(), IntegerValue::fromInt($value));
    }

    public function withBooleanVariable(string $name, bool $value): self
    {
        return $this->withVariable($name, new BooleanType(), BooleanValue::fromBoolean($value));
    }

    public function withChoicesVariable(
        string $name,
        array $selectedOptions,
        array $availableOptions
    ): self {
        if (count($selectedOptions) === 0) {
            throw new InvalidAuthorizedChoices('Cannot have empty selected options.');
        }

        if (count($availableOptions) === 0) {
            throw new InvalidAuthorizedChoices('Cannot have empty available options.');
        }

        return $this->withVariable(
            $name,
            new ChoicesOfMixedType(ArrayOfValues::arrayOfUnknowns(...$availableOptions)),
            ArrayOfValues::arrayOfUnknowns(...$selectedOptions)
        );
    }

    private function withVariable(string $name, VariableType $type, VariableValue $value): self
    {
        $this->variables[] = new CardVariable($name, $type->createValueFromMixed($value));

        return $this;
    }

    public function buildCard(array $placeholderData = []): Card
    {
        $variableBuilder = new VariableBuilder();
        $data = PlaceholderData::fromArray($placeholderData);
        foreach ($this->placeholders as $placeholder) {
            $this->variables = array_merge(
                $this->variables,
                $placeholder->buildVariables($variableBuilder, $data)
            );
        }

        return new class(
            new MapOfVariables(...$this->variables),
            new MapOfBehaviors(...$this->behaviors)
        ) implements Card {
            /**
             * @var MapOfVariables
             */
            private $variables;

            /**
             * @var MapOfBehaviors
             */
            private $behaviors;

            public function __construct(
                MapOfVariables $variables,
                MapOfBehaviors $behaviors
            ) {
                $this->variables = $variables;
                $this->behaviors = $behaviors;
            }

            public function acceptCardVisitor(CardVisitor $visitor): void
            {
                $this->variables->acceptCardVisitor($visitor);
                $this->behaviors->acceptCardVisitor($visitor);
            }

            public function getVariableValue(string $name): VariableValue
            {
                $variable = $this->variables[$name];

                return $variable->getValue();
            }
        };
    }

    public static function create(): self
    {
        return new self();
    }
}
