<?php declare(strict_types=1);

namespace Star\GameEngine\Examples\TicTacToe;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Extension\Logging\CollectMessages;

final class GameOfTicTacToeTest extends TestCase
{
    public function test_should_result_in_a_win_for_player_one(): void
    {
        /**
         *  O |   | X
         * ------------
         *  O | X |
         * ------------
         *  X |   |
         */
        $game = new GameOfTicTacToe(
            $logger = new CollectMessages(CollectMessages::LOG_LISTENER),
            'p1',
            'p2'
        );
        self::assertFalse($game->playToken('p1', 'B,2'));
        self::assertFalse($game->playToken('p2', 'A,1'));
        self::assertFalse($game->playToken('p1', 'A,3'));
        self::assertFalse($game->playToken('p2', 'A,2'));
        self::assertTrue($game->playToken('p1', 'C,1'));
        self::assertSame(
            [
                'Player "p1" played its token at coordinate "B,2".',
                'Player "p2" played its token at coordinate "A,1".',
                'Player "p1" played its token at coordinate "A,3".',
                'Player "p2" played its token at coordinate "A,2".',
                'Player "p1" played its token at coordinate "C,1".',
                'The game was won by player "p1".',
            ],
            $logger->getMessages()
        );
        self::assertCount(1, $winners = $game->getGameResult()->getWinningPlayers());
        self::assertSame('p1', $winners[0]->toString());
    }

    public function test_should_result_in_a_win_for_player_two(): void
    {
        /**
         *  O |   | X
         * ------------
         *  O | X |
         * ------------
         *  O |   | X
         */
        $game = new GameOfTicTacToe(
            $logger = new CollectMessages(CollectMessages::LOG_LISTENER),
            'p1',
            'p2'
        );
        self::assertFalse($game->playToken('p1', 'C,1'));
        self::assertFalse($game->playToken('p2', 'A,1'));
        self::assertFalse($game->playToken('p1', 'B,2'));
        self::assertFalse($game->playToken('p2', 'A,2'));
        self::assertFalse($game->playToken('p1', 'C,3'));
        self::assertTrue($game->playToken('p2', 'A,3'));
        self::assertSame(
            [
                'Player "p1" played its token at coordinate "C,1".',
                'Player "p2" played its token at coordinate "A,1".',
                'Player "p1" played its token at coordinate "B,2".',
                'Player "p2" played its token at coordinate "A,2".',
                'Player "p1" played its token at coordinate "C,3".',
                'Player "p2" played its token at coordinate "A,3".',
                'The game was won by player "p2".',
            ],
            $logger->getMessages()
        );
        self::assertCount(1, $winners = $game->getGameResult()->getWinningPlayers());
        self::assertSame('p2', $winners[0]->toString());
    }

    public function test_should_result_in_a_tie(): void
    {
        /**
         *  O | X | X
         * ------------
         *  X | X | O
         * ------------
         *  O | O | X
         */
        $game = new GameOfTicTacToe(
            $logger = new CollectMessages(CollectMessages::LOG_LISTENER),
            'p1',
            'p2'
        );
        self::assertFalse($game->playToken('p1', 'B,1'));
        self::assertFalse($game->playToken('p2', 'A,1'));
        self::assertFalse($game->playToken('p1', 'C,1'));
        self::assertFalse($game->playToken('p2', 'C,2'));
        self::assertFalse($game->playToken('p1', 'B,2'));
        self::assertFalse($game->playToken('p2', 'B,3'));
        self::assertFalse($game->playToken('p1', 'A,2'));
        self::assertFalse($game->playToken('p2', 'A,3'));
        self::assertTrue($game->playToken('p1', 'C,3'));
        self::assertSame(
            [
                'Player "p1" played its token at coordinate "B,1".',
                'Player "p2" played its token at coordinate "A,1".',
                'Player "p1" played its token at coordinate "C,1".',
                'Player "p2" played its token at coordinate "C,2".',
                'Player "p1" played its token at coordinate "B,2".',
                'Player "p2" played its token at coordinate "B,3".',
                'Player "p1" played its token at coordinate "A,2".',
                'Player "p2" played its token at coordinate "A,3".',
                'Player "p1" played its token at coordinate "C,3".',
                'The game ended with a tie.',
            ],
            $logger->getMessages()
        );
        self::assertCount(0, $game->getGameResult()->getWinningPlayers());
    }
}
