<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

interface DeckVisitor
{
    /**
     * @param Card $card
     * @return bool Whether the iteration must stop after this visit.
     */
    public function visitCard(Card $card): bool;
}
