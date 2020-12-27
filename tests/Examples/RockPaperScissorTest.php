<?php declare(strict_types=1);

namespace Star\GameEngine\Examples;

use Assert\Assertion;
use PHPStan\Testing\TestCase;
use RuntimeException;
use Star\GameEngine\GameEngine;
use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\PlayerId;
use function array_map;
use function array_pop;
use function implode;
use function sprintf;

final class RockPaperScissorTest extends TestCase
{
    private function runGameWithEngine(
        RockPaperScissorAction $playerOne,
        RockPaperScissorAction $playerTwo
    ): RockPaperScissorObserver {
        $game = new GameEngine();
        $game->addHandler(
            PlayRockPaperScissor::class,
            function (PlayRockPaperScissor $event): void {
                // do nothing, all handled in Observer
            }
        );
        $game->addObserver($observer = new RockPaperScissorObserver());
        $game->dispatchCommand(new PlayRockPaperScissor($playerOne, $playerTwo));

        return $observer;
    }

//    private function createGameWithBuilder(): Engine
//    {
//        $handler = function(RockPaperScissorAction $action): void {
//            \var_dump($action);
//        };
//        $this->game = GameBuilder::newGame('Rock Paper Scissor')
//            ->addHandler(PlayRock::class, $handler)
//            ->addHandler(PlayPaper::class, $handler)
//            ->addHandler(PlayScissor::class, $handler)
//            ->addFunction(
//                'endGame',
//                function () {
//
//                }
//            )
//            ->addTrigger('true = isWon()', 'endGame()')
////            ->withPhase('main')
////            ->endPhase()
//            ->createGame();
//    }

    public function test_it_should_end_in_a_win(): void
    {
        $resultOne = $this->runGameWithEngine(
            new PlayScissor('p1'),
            new PlayPaper('p2')
        );

        self::assertTrue($resultOne->isWon());
        self::assertSame('p1', $resultOne->getResult());

        $resultTwo = $this->runGameWithEngine(
            new PlayRock('p1'),
            new PlayPaper('p2')
        );

        self::assertTrue($resultTwo->isWon());
        self::assertSame('p2', $resultTwo->getResult());

        $resultThree = $this->runGameWithEngine(
            new PlayScissor('p1'),
            new PlayRock('p2')
        );

        self::assertTrue($resultThree->isWon());
        self::assertSame('p2', $resultThree->getResult());
    }

    public function test_it_should_end_in_a_tie(): void
    {
        $result = $this->runGameWithEngine(
            new PlayScissor('p1'),
            new PlayScissor('p2')
        );

        self::assertFalse($result->isWon());
        self::assertSame('TIE', $result->getResult());
    }
}

final class RockPaperScissorObserver implements EngineObserver
{
    /**
     * @var PlayerId|null
     */
    private $winner;

    public function isWon(): bool
    {
        return $this->winner instanceof PlayerId;
    }

    /**
     * @return string The player id that won or "TIE".
     */
    public function getResult(): string
    {
        if ($this->isWon()) {
            return $this->winner->toString();
        }

        return 'TIE';
    }

    public function notifyScheduleCommand(GameCommand $command): void
    {
        if (! $command instanceof PlayRockPaperScissor) {
            throw new RuntimeException(__METHOD__ . ' not implemented yet.');
        }

        $actionMap = [];
        foreach ($command->actions() as $action) {
            $actionMap[$action->action()][] = $action->playerId();
        }

        if (isset($actionMap[RockPaperScissorAction::ROCK], $actionMap[RockPaperScissorAction::PAPER])) {
            Assertion::count($actionMap[RockPaperScissorAction::PAPER], 1);
            $this->winner = array_pop($actionMap[RockPaperScissorAction::PAPER]);
        } else if (isset($actionMap[RockPaperScissorAction::SCISSOR], $actionMap[RockPaperScissorAction::PAPER])) {
            Assertion::count($actionMap[RockPaperScissorAction::SCISSOR], 1);
            $this->winner = array_pop($actionMap[RockPaperScissorAction::SCISSOR]);
        } else if (isset($actionMap[RockPaperScissorAction::SCISSOR], $actionMap[RockPaperScissorAction::ROCK])) {
            Assertion::count($actionMap[RockPaperScissorAction::ROCK], 1);
            $this->winner = array_pop($actionMap[RockPaperScissorAction::ROCK]);
        }
    }

    public function notifyListenerDispatch(callable $listener, GameEvent $event): void
    {
        throw new RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}

final class PlayRockPaperScissor implements GameCommand
{
    /**
     * @var RockPaperScissorAction[]
     */
    private $actions;

    public function __construct(
        RockPaperScissorAction $playerOne,
        RockPaperScissorAction $playerTwo
    ) {
        $this->actions = [$playerOne, $playerTwo];
    }

    public function actions(): array
    {
        return $this->actions;
    }

    public function toString(): string
    {
        return sprintf(
            'Players are playing the following actions: %s',
            implode(
                ',',
                array_map(
                    function (RockPaperScissorAction $action): string {
                        return sprintf(
                            '%s: %s',
                            $action->playerId()->toString(),
                            $action->action()
                        );
                    },
                    $this->actions
                )
            )
        );
    }

    public function payload(): array
    {
        $payload = [];
        foreach ($this->actions as $action) {
            $payload[]['player_id'] = $action->playerId()->toString();
            $payload[]['action'] = $action->action();
        }

        return $payload;
    }
}

final class ActionsWerePlayed extends GameEvent
{
    /**
     * @var RockPaperScissorAction[]
     */
    private $actions;

    public function __construct(
        RockPaperScissorAction $playerOne,
        RockPaperScissorAction $playerTwo
    ) {
        $this->actions = [$playerOne, $playerTwo];
    }

    public function actions(): array
    {
        return $this->actions;
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

abstract class RockPaperScissorAction
{
    const ROCK = 'ROCK';
    const PAPER = 'PAPER';
    const SCISSOR = 'SCISSOR';

    /**
     * @var PlayerId
     */
    private $playerId;

    public function __construct(string $playerId)
    {
        $this->playerId = PlayerId::fromString($playerId);
    }

    public function playerId(): PlayerId
    {
        return $this->playerId;
    }

    abstract public function action(): string;
}

final class PlayRock extends RockPaperScissorAction
{
    public function action(): string
    {
        return self::ROCK;
    }
}

final class PlayPaper extends RockPaperScissorAction
{
    public function action(): string
    {
        return self::PAPER;
    }
}

final class PlayScissor extends RockPaperScissorAction
{
    public function action(): string
    {
        return self::SCISSOR;
    }
}
