<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use Countable;
use Star\GameEngine\Component\Card\Shuffling\RandomShuffle;
use Star\GameEngine\Component\Card\Shuffling\ShuffleStrategy;
use function array_merge;
use function array_pop;
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
        $this->cards = $cards;
    }

    public function acceptDeckVisitor(DeckVisitor $visitor): void
    {
        foreach ($this->cards as $card) {
            if ($visitor->visitCard($card)) {
                break;
            }
        }
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

    public function merge(DeckOfCard $deck): self
    {
        return new self($this->name, ...array_merge($this->cards, $deck->cards));
    }

    public function shuffle(ShuffleStrategy $strategy = null): self
    {
        if (! $strategy) {
            $strategy = new RandomShuffle();
        }

        return new DeckOfCard($this->name, ...$strategy->shuffleDeck(...$this->cards));
    }

    public function count(): int
    {
        return count($this->cards);
    }
}
