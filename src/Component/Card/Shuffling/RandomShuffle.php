<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Shuffling;

use Star\GameEngine\Component\Card\Card;
use function shuffle;

final class RandomShuffle implements ShuffleStrategy
{
    public function shuffleDeck(Card ...$cards): array
    {
        shuffle($cards);

        return $cards;
    }
}
