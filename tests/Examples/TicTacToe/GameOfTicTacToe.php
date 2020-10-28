<?php declare(strict_types=1);

namespace Star\GameEngine\Examples\TicTacToe;

use Psr\Log\LoggerInterface;
use RuntimeException;
use Star\GameEngine\Component\Token\StringToken;
use Star\GameEngine\Context\ContextBuilder;
use Star\GameEngine\Context\ContextRegistry;
use Star\GameEngine\Context\GameContext;
use Star\GameEngine\GameEngine;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\PlayerId;
use Star\GameEngine\Result\GameResult;
use Star\GameEngine\View\Grid\AlphabeticHeader;
use Star\GameEngine\View\Grid\Coordinate;
use Star\GameEngine\View\Grid\GridBuilder;
use Star\GameEngine\View\Grid\NumericHeader;
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

    public function __construct(LoggerInterface $logger, string $playerOne, string $playerTwo)
    {
        $this->playerOne = PlayerId::fromString($playerOne);
        $this->playerTwo = PlayerId::fromString($playerTwo);
        $this->game = new GameEngine();
        $builder = new GridBuilder(new AlphabeticHeader(3), new NumericHeader(3));
        $grid = $builder->createGrid();

        $this->game->addHandler(
            PlayToken::class,
            function (PlayToken $command) use ($grid, $logger) {
                $logger->debug($command->toString(), $command->payload());

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
            function (TokenWasPlayed $event) use ($grid, $logger) {
                $logger->info($event->toString(), $event->payload());

                $isTie = false; // all cells are filled, with no winner
                $isWon = false; // 1 token is present in all cells of 1 row/column/x-line

                if ($isWon) {
                    $this->game->dispatchEvent(new GameWasWon($event->playerId()));
// todo                    $this->getContext()->markAsWon($event->playerId());
                } else if ($isTie) {
                    $this->game->dispatchEvent(new GameWasTied());
// todo                    $this->getContext()->markAsTie();
                }
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
