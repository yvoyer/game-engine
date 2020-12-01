<?php declare(strict_types=1);

namespace Star\GameEngine\Examples\TicTacToe;

use Star\GameEngine\Component\Token\GameToken;
use Star\GameEngine\Component\Token\StringToken;
use Star\GameEngine\Component\View\Coordinate;
use Star\GameEngine\Component\View\Grid\AlphabeticHeader;
use Star\GameEngine\Component\View\Grid\Grid;
use Star\GameEngine\Component\View\Grid\GridBuilder;
use Star\GameEngine\Component\View\Grid\GridVisitor;
use Star\GameEngine\Component\View\Grid\NumericHeader;
use Star\GameEngine\Context\ContextBuilder;
use Star\GameEngine\Context\ContextRegistry;
use Star\GameEngine\Context\GameContext;
use Star\GameEngine\Extension\Logging\CollectMessages;
use Star\GameEngine\GameEngine;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\PlayerId;
use Star\GameEngine\Result\GameResult;
use function implode;
use function in_array;
use function sprintf;
use function strlen;

final class GameOfTicTacToe
{
    /**
     * @var PlayerId
     */
    private $playerOne;

    /**
     * @var PlayerId
     */
    private $playerTwo;

    /**
     * @var GameEngine
     */
    private $game;

    /**
     * @var Grid
     */
    private $grid;

    /**
     * @var PlayerId|null
     */
    private $winner;

    public function __construct(CollectMessages $observer, string $playerOne, string $playerTwo)
    {
        $this->playerOne = PlayerId::fromString($playerOne);
        $this->playerTwo = PlayerId::fromString($playerTwo);
        $this->game = new GameEngine();
        $this->game->addObserver($observer);

        $builder = new GridBuilder();
        $this->grid = $builder->square(3, new AlphabeticHeader(), new NumericHeader());

        $this->game->addHandler(
            PlayToken::class,
            function (PlayToken $command) {
                $token = 'O';
                if ($this->playerOne->toString() === $command->playerId()->toString()) {
                    $token = 'X';
                }

                $this->grid->placeToken($command->coordinate(), StringToken::fromString($token));

                $this->game->dispatchEvent(new TokenWasPlayed($command->playerId(), $command->coordinate()));
            }
        );

        $this->game->addListener(
            TokenWasPlayed::class,
            function (TokenWasPlayed $event) {
                $this->grid->acceptGridVisitor($checker = new TicTacToeWinningConditions());

                if ($checker->isWon()) {
                    $this->game->dispatchEvent(new GameWasWon($event->playerId()));
                }

                if ($checker->isTied()) {
                    $this->game->dispatchEvent(new GameWasTied());
                }

                // continue playing
            },
            0
        );

        $this->game->addListener(
            GameWasWon::class,
            function (GameWasWon $event) {
                $this->getContext()->endGame();
                $this->winner = $event->winner();
            },
            0
        );

        $this->game->addListener(
            GameWasTied::class,
            function () {
                $this->getContext()->endGame();
            },
            0
        );

        $this->game->addContextBuilder(new TicTacToeContext(false));
    }

    /**
     * @param string $playerId
     * @param string $coordinate
     * @return bool Whether the game has ended
     */
    public function playToken(string $playerId, string $coordinate): bool
    {
        $this->game->dispatchCommand(
            new PlayToken(
                PlayerId::fromString($playerId),
                Coordinate::fromString($coordinate)
            )
        );

        return $this->getContext()->isEnded();
    }

    public function getGameResult(): GameResult
    {
        $result = new GameResult();
        if ($this->winner) {
            $result->addWinningPlayer($this->winner);
        }

        return $result;
    }

    private function getContext(): TicTacToeContext
    {
        return $this->game->getContext('state');
    }
}

final class TicTacToeContext implements ContextBuilder, GameContext
{
    /**
     * @var bool
     */
    private $state;

    public function __construct(bool $state)
    {
        $this->state = $state;
    }

    public function isEnded(): bool
    {
        return $this->state;
    }

    public function endGame(): void
    {
        $this->state = true;
    }

    public function create(ContextRegistry $registry): ContextRegistry
    {
        $registry->updateContext('state', $this);

        return $registry;
    }
}

final class PlayToken implements GameCommand
{
    /**
     * @var PlayerId
     */
    private $playerId;

    /**
     * @var Coordinate
     */
    private $coordinate;

    public function __construct(PlayerId $playerId, Coordinate $coordinate)
    {
        $this->playerId = $playerId;
        $this->coordinate = $coordinate;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function coordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function toString(): string
    {
        return sprintf(
            'Player "%s" is placing its token at coordinate "%s".',
            $this->playerId()->toString(),
            $this->coordinate()->toString()
        );
    }

    public function payload(): array
    {
        return [
            'player_id' => $this->playerId()->toString(),
            'coordinate' => $this->coordinate()->toString(),
        ];
    }
}

final class TokenWasPlayed extends GameEvent
{
    /**
     * @var PlayerId
     */
    private $playerId;

    /**
     * @var Coordinate
     */
    private $coordinate;

    public function __construct(PlayerId $playerId, Coordinate $coordinate)
    {
        $this->playerId = $playerId;
        $this->coordinate = $coordinate;
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    public function coordinate(): Coordinate
    {
        return $this->coordinate;
    }

    public function toString(): string
    {
        return sprintf(
            'Player "%s" played its token at coordinate "%s".',
            $this->playerId()->toString(),
            $this->coordinate()->toString()
        );
    }

    public function payload(): array
    {
        return [
            'player_id' => $this->playerId()->toString(),
            'coordinate' => $this->coordinate()->toString(),
        ];
    }
}

final class GameWasWon extends GameEvent
{
    /**
     * @var PlayerId
     */
    private $winner;

    public function __construct(PlayerId $winner)
    {
        $this->winner = $winner;
    }

    public function winner(): PlayerId
    {
        return $this->winner;
    }

    public function toString(): string
    {
        return sprintf('The game was won by player "%s".', $this->winner->toString());
    }

    public function payload(): array
    {
        return [
            'winner_id' => $this->winner->toString(),
        ];
    }
}

final class GameWasTied extends GameEvent
{
    public function toString(): string
    {
        return 'The game ended with a tie.';
    }

    public function payload(): array
    {
        return [];
    }
}

final class TicTacToeWinningConditions implements GridVisitor
{
    const ALL_X = 'XXX';
    const ALL_O = 'OOO';
    const DIAGONAL_ONE = 0;
    const DIAGONAL_TWO = 1;

    /**
     * @var string[][]
     */
    private $lines = [];

    /**
     * @var string[][]
     */
    private $columns = [];

    /**
     * @var string[][]
     */
    private $diagonals = [];

    /**
     * @var string[]
     */
    private $grid = [];

    public function enterGrid(): void
    {
        $this->lines = [];
        $this->columns = [];
        $this->diagonals = [];
        $this->grid = [];
    }

    public function visitTokenAtCoordinate(Coordinate $coordinate, GameToken $token): void
    {
        $this->columns[$coordinate->getX()][$coordinate->getY()] = $token->toString();
        $this->lines[$coordinate->getY()][$coordinate->getX()] = $token->toString();

        if (in_array($coordinate->toString(), ['A,1', 'B,2', 'C,3'])) {
            $this->diagonals[self::DIAGONAL_ONE][] = $token->toString();
        }

        if (in_array($coordinate->toString(), ['A,3', 'B,2', 'C,1'])) {
            $this->diagonals[self::DIAGONAL_TWO][] = $token->toString();
        }

        $this->grid[] = $token->toString();
    }

    public function isWon(): bool
    {
        foreach ($this->lines as $line => $columns) {
            $stringLine = implode('', $columns);
            if ($stringLine === self::ALL_X || $stringLine === self::ALL_O) {
                return true;
            }
        }

        foreach ($this->columns as $column => $lines) {
            $stringColumn = implode('', $lines);
            if ($stringColumn === self::ALL_X || $stringColumn === self::ALL_O) {
                return true;
            }
        }

        $firstDiagonal = implode('', $this->diagonals[self::DIAGONAL_ONE]);
        if ($firstDiagonal === self::ALL_X || $firstDiagonal === self::ALL_O) {
            return true;
        }

        $secondDiagonal = implode('', $this->diagonals[self::DIAGONAL_TWO]);
        if ($secondDiagonal === self::ALL_X || $secondDiagonal === self::ALL_O) {
            return true;
        }

        return false;
    }

    public function isTied(): bool
    {
        return strlen(implode('', $this->grid)) === 9 && ! $this->isWon();
    }
}
