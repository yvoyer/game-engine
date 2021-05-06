<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use Star\GameEngine\Component\Card\Prototyping\CardBehavior;
use Star\GameEngine\Component\Card\Prototyping\CardVariable;
use Star\GameEngine\Component\Card\Prototyping\MapOfBehaviors;
use Star\GameEngine\Component\Card\Prototyping\MapOfVariables;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\BooleanPlaceholder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\IntegerPlaceholder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\PlaceholderBuilder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\PlaceholderData;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\TemplatePlaceholder;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\TextPlaceholder;
use Star\GameEngine\Component\Card\Prototyping\Type\BooleanType;
use Star\GameEngine\Component\Card\Prototyping\Type\IntegerType;
use Star\GameEngine\Component\Card\Prototyping\Type\TextType;
use Star\GameEngine\Component\Card\Prototyping\Type\VariableType;
use Star\GameEngine\Component\Card\Prototyping\Value\VariableValue;
use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;

final class CardBuilder
{
    /**
     * @var CardVariable[]
     */
    private $variables = [];

    /**
     * @var TextPlaceholder[]
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
        return $this->withPlaceholder(new TextPlaceholder($name));
    }

    public function withIntegerPlaceholder(string $name): PlaceholderBuilder
    {
        return $this->withPlaceholder(new IntegerPlaceholder($name));
    }

    public function withBooleanPlaceholder(string $name): PlaceholderBuilder
    {
        return $this->withPlaceholder(new BooleanPlaceholder($name));
    }

    public function withPlaceholder(TemplatePlaceholder $placeholder): PlaceholderBuilder
    {
        $this->placeholders[] = $placeholder;

        return new PlaceholderBuilder($placeholder, $this);
    }

    public function withTextVariable(string $name, string $value): self
    {
        return $this->withVariable($name, new TextType(), $value);
    }

    public function withIntegerVariable(string $name, int $value): self
    {
        return $this->withVariable($name, new IntegerType(), (string) $value);
    }

    public function withBooleanVariable(string $name, bool $value): self
    {
        return $this->withVariable($name, new BooleanType(), $value);
    }

    public function withVariable(string $name, VariableType $type, $value): self
    {
        $this->variables[] = new CardVariable($name, $type->createValueFromMixed($value));

        return $this;
    }

    public function buildCard(array $placeholderData = []): Card
    {
        $variableBuilder = new VariableBuilder();
        $data = PlaceholderData::fromArray($placeholderData);
        foreach ($this->placeholders as $placeholder) {
            $this->variables = \array_merge(
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
