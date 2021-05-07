<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Shuffling;

use Star\GameEngine\Component\Card\Card;
use function array_reverse;

final class ReverseOrder implements ShuffleStrategy
{
    public function shuffleDeck(Card ...$cards): array
    {
        return array_reverse($cards);
    }
}
