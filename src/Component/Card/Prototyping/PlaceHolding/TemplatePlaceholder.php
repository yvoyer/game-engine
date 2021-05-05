<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Star\GameEngine\Component\Card\Prototyping\CardVariable;

interface TemplatePlaceholder
{
    /**
     * @param PlaceholderData $data
     *
     * @return CardVariable[]
     */
    public function buildVariables(PlaceholderData $data): array;
}
