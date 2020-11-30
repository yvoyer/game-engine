<?php declare(strict_types=1);

namespace Star\GameEngine\Result;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\PlayerId;

final class GameResultTest extends TestCase
{
    public function test_it_should_allow_multiple_winning_players(): void
    {
        $result = new GameResult();
        $result->addWinningPlayer(PlayerId::fromString('1'));
        $result->addWinningPlayer(PlayerId::fromString('2'));

        self::assertCount(2, $result->getWinningPlayers());
        self::assertContainsOnlyInstancesOf(PlayerId::class, $result->getWinningPlayers());
    }
}
