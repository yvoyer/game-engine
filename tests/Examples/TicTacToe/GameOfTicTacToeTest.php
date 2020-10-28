<?php declare(strict_types=1);

namespace Star\GameEngine\Examples\TicTacToe;

use PHPUnit\Framework\TestCase;
use Psr\Log\Test\TestLogger;

final class GameOfTicTacToeTest extends TestCase
{
    public function test_should_result_in_a_win_for_player_one(): void
    {
        $game = new GameOfTicTacToe($logger = new TestLogger(), 'p1', 'p2');
        self::assertFalse($game->playToken('p1', 'B,2'));
        self::assertFalse($game->playToken('p2', 'A,1'));
        self::assertFalse($game->playToken('p1', 'A,3'));
        self::assertFalse($game->playToken('p2', 'A,2'));
        self::assertTrue($game->playToken('p1', 'A,3'));
        self::assertSame(
            [

            ],
            $logger->records
        );
    }

    public function test_should_result_in_a_win_for_player_two(): void
    {
        $this->fail('todo');
        $game = new GameOfTicTacToe('p1', 'p2');
        self::assertFalse($game->playToken('p1', 'B,2'));

    }

    public function test_should_result_in_a_tie(): void
    {
        $this->fail('todo');
        $game = new GameOfTicTacToe('p1', 'p2');
        self::assertFalse($game->playToken('p1', 'B,2'));

    }
}
