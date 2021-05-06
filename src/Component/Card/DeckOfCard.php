<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use Countable;
use function array_pop;
use function array_reverse;
use function count;
use function sprintf;

final class DeckOfCard implements Countable
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Card[]
     */
    private $cards;

    public function __construct(string $name, Card ...$cards)
    {
        $this->name = $name;
        $this->cards = array_reverse($cards);
    }

    public function drawTopCard(): Card
    {
        if ($this->count() === 0) {
            throw new EmptyDeck(
                sprintf('Deck "%s" is empty, cannot draw any cards.', $this->name)
            );
        }

        return array_pop($this->cards);
    }

    public function drawTopCards(int $quantity): DeckOfCard
    {
        $cards = [];
        for ($i = 0; $i < $quantity; $i++) {
            $cards[] = $this->drawTopCard();
        }

        return new self($this->name, ...$cards);
    }

    public function acceptDeckVisitor(DeckVisitor $visitor): void
    {
        foreach ($this->cards as $card) {
            if ($visitor->visitCard($card)) {
                break;
            }
        }
    }

    public function count(): int
    {
        return count($this->cards);
    }
}
