<?php declare(strict_types=1);

namespace Star\GameEngine\Examples\TicTacToe;

use Psr\Log\LoggerInterface;
use RuntimeException;
use Star\GameEngine\Component\Token\GameToken;
use Star\GameEngine\Component\Token\StringToken;
use Star\GameEngine\Component\View\Coordinate;
use Star\GameEngine\Component\View\Grid\AlphabeticHeader;
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
use function sprintf;

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

    public function __construct(CollectMessages $observer, string $playerOne, string $playerTwo)
    {
        $this->playerOne = PlayerId::fromString($playerOne);
        $this->playerTwo = PlayerId::fromString($playerTwo);
        $this->game = new GameEngine();
        $this->game->addObserver($observer);

        $builder = new GridBuilder();
        $grid = $builder->square(3, new AlphabeticHeader(), new NumericHeader());

        $this->game->addHandler(
            PlayToken::class,
            function (PlayToken $command) use ($grid) {
                $token = 'O';
                if ($this->playerOne->toString() === $command->playerId()->toString()) {
                    $token = 'X';
                }

                $grid->placeToken($command->coordinate(), StringToken::fromString($token));

                $this->game->dispatchEvent(new TokenWasPlayed($command->playerId(), $command->coordinate()));
            }
        );

        $this->game->addListener(
            TokenWasPlayed::class,
            function (TokenWasPlayed $event) use ($grid) {
                $grid->acceptGridVisitor($checker = new TicTacToeWinningConditions());

                if ($checker->isWin()) {
                    $this->game->dispatchEvent(new GameWasWon($event->playerId()));
// todo                    $this->getContext()->markAsWon($event->playerId());
                } else if ($checker->isTied()) {
// todo                    $this->getContext()->markAsTie();
                    $this->game->dispatchEvent(new GameWasTied());
                } // continue playing
            },
            0
        );

        $this->game->addListener(
            GameWasWon::class,
            function (GameWasWon $event) {
                \var_dump($event); // todo use context to end game, or event?
                throw new RuntimeException(__METHOD__ . ' todo');
            },
            0
        );

        $this->game->addListener(
            GameWasTied::class,
            function (GameWasTied $event) {
                \var_dump($event);
                throw new RuntimeException(__METHOD__ . ' todo');
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

        return $this->getStateContext()->isEnded();
    }

    public function getGameResult(): GameResult
    {
        return $this->game->getGameResult();
        // todo return logs, plays, result (won tie ...) anything that can be captured to export and replay?
    }

    private function getStateContext(): TicTacToeContext
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
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function payload(): array
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}

final class GameWasTied extends GameEvent
{
    public function toString(): string
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function payload(): array
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}

final class TicTacToeWinningConditions implements GridVisitor
{
    /**
     * @var GameToken[][]
     */
    private $lines = [];

    /**
     * @var GameToken[][]
     */
    private $columns = [];

    /**
     * @var GameToken[]
     */
    private $diagonals = [];

#$isTie = false; // all cells are filled, with no winner
#$isWon = false; // 1 token is present in all cells of 1 row/column/x-line
    public function enterGrid(): void
    {
        $this->lines = [];
        $this->columns = [];
        $this->diagonals = [];
    }

    public function visitTokenAtCoordinate(Coordinate $coordinate, GameToken $token): void
    {
        $this->lines[$coordinate->getX()][$coordinate->getY()] = $token;
        $this->columns[$coordinate->getY()][$coordinate->getX()] = $token;
        if (\in_array($coordinate->toString(), ['A1', 'B2', 'C3'])) {
            $this->diagonals[] = $token;
        }
        if (\in_array($coordinate->toString(), ['C1', 'B2', 'A3'])) {
            $this->diagonals[] = $token;
        }
    }

    public function isWin(): bool
    {
        \var_dump($this->lines, $this->columns, $this->diagonals);
        foreach ($this->lines as $line => $columns) {

            $winner = '';
            foreach ($columns as $column => $token) {
                if (\mb_strlen($token->toString()) === 0) {
                    break;
                }

                if ($winner === '') {
                    $winner = $token->toString();
                    continue;
                }

                if ($token->toString() !== $winner) {
                    break;
                }
            }
            \var_dump($winner);
        }

    }

    public function isTied(): bool
    {

    }
}
