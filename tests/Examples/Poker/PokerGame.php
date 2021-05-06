<?php declare(strict_types=1);

namespace Star\GameEngine\Examples\Poker;

use Star\GameEngine\Component\Card\CardBuilder;
use Star\GameEngine\Component\Card\DeckOfCard;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\PlaceholderData;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\TemplatePlaceholder;
use Star\GameEngine\Component\Card\Prototyping\VariableBuilder;

final class PokerGame
{
    /**
     * @var DeckOfCard|null
     */
    private $deck;

    public function setup(): void
    {
        $template = CardBuilder::create()
            ->withPlaceholder(new class() implements TemplatePlaceholder {
                public function buildVariables(VariableBuilder $builder, PlaceholderData $data): array
                {
                    return [
                        $builder->integerVariable('number', $data->getIntegerValue('number')),
                        $builder->textVariable('kind', $data->getStringValue('kind')),
                    ];
                }
            });

        $cards = [];
        $numbers = \range(1, 13);
        $kinds = ['heart', 'spades', 'club', 'diamond'];
        foreach ($numbers as $number) {
            foreach ($kinds as $kind) {
                $cards[] = $template->buildCard(
                    [
                        'number' => $number,
                        'kind' => $kind,
                    ]
                );
            }
        }

        $this->deck = new DeckOfCard('main', ...$cards);
    }

    public function deck(): DeckOfCard
    {
        return $this->deck;
    }
}
