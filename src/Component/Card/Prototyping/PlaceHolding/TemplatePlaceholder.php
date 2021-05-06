<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Star\GameEngine\Component\Card\Prototyping\CardVariable;
use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;

interface TemplatePlaceholder
{
    /**
     * @param VariableBuilder $builder
     * @param PlaceholderData $data
     * @return CardVariable[]
     */
    public function buildVariables(VariableBuilder $builder, PlaceholderData $data): array;
}
