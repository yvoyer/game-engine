<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Shuffling;

use Star\GameEngine\Component\Card\Card;

interface ShuffleStrategy
{
    public function shuffleDeck(Card ...$cards): array;
}
