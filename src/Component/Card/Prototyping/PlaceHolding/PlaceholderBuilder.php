<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Star\GameEngine\Component\Card\Card;
use Star\GameEngine\Component\Card\CardBuilder;

/**
 * @internal This class is internal to the CardBuilder class.
 * @see CardBuilder
 */
final class PlaceholderBuilder
{
    /**
     * @var TemplatePlaceholder
     */
    private $placeholder;

    /**
     * @var CardBuilder
     */
    private $builder;

    public function __construct(TemplatePlaceholder $placeholder, CardBuilder $builder)
    {
        $this->placeholder = $placeholder;
        $this->builder = $builder;
    }

    public function endPlaceholder(): CardBuilder
    {
        return $this->builder;
    }

    public function buildCard(array $placeholderData = []): Card
    {
        return $this->builder->buildCard($placeholderData);
    }
}
