<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Star\GameEngine\Component\Card\Prototyping\Value\ArrayOfValues;
use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;

final class ChoicesPlaceholder implements TemplatePlaceholder
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $authorizedValues;

    public function __construct(string $name, ArrayOfValues $authorizedValues)
    {
        $this->name = $name;
        $this->authorizedValues = $authorizedValues;
    }

    public function buildVariables(VariableBuilder $builder, PlaceholderData $data): array
    {
        return [
            $builder->choicesVariable(
                $this->name,
                $data->getChoicesValue($this->name),
                $this->authorizedValues
            ),
        ];
    }
}
