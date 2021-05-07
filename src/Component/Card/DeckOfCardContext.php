<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use Countable;
use Star\GameEngine\Context\GameContext;
use function count;

final class DeckOfCardContext implements GameContext, Countable
{
    /**
     * @var DeckOfCard
     */
    private $deck;

    public function __construct(DeckOfCard $deck)
    {
        $this->deck = $deck;
    }

    public function count(): int
    {
        return count($this->deck);
    }
}
