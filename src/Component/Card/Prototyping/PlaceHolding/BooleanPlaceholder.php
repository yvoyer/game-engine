<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;

final class BooleanPlaceholder implements TemplatePlaceholder
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function buildVariables(VariableBuilder $builder, PlaceholderData $data): array
    {
        return [
            $builder->booleanVariable($this->name, $data->getBooleanValue($this->name)),
        ];
    }
}
