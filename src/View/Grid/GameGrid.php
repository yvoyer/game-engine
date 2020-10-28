<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use Star\GameEngine\Component\Token\GameToken;

interface GameGrid
{
    /**
     * @param Coordinate $coordinate
     * @param GameToken $token
     */
    public function placeToken(Coordinate $coordinate, GameToken $token): void;
}
