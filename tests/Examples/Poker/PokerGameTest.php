<?php declare(strict_types=1);

namespace Star\GameEngine\Examples\Poker;

use PHPUnit\Framework\TestCase;

final class PokerGameTest extends TestCase
{
    /**
     * @var PokerGame
     */
    private $game;

    protected function setUp(): void
    {
        $this->game = new PokerGame();
    }

    public function test_it_should_build_deck_of_cards(): void
    {
        $this->game->setup();
        self::assertCount(52, $this->game->deck());
    }
}
