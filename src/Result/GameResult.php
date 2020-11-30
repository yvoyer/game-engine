<?php declare(strict_types=1);

namespace Star\GameEngine\Result;

use Star\GameEngine\PlayerId;

final class GameResult
{
    /**
     * @var PlayerId[]
     */
    private $winners = [];

    public function addWinningPlayer(PlayerId $id): void
    {
        $this->winners[] = $id;
    }

    /**
     * @return PlayerId[]
     */
    public function getWinningPlayers(): array
    {
        return $this->winners;
    }
}
