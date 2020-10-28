<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use Star\GameEngine\Component\Token\GameToken;

final class Grid implements GameGrid
{
    /**
     * @var string[]
     */
    private $cells = [];

    public function createCell(Coordinate $coordinate): void {
        $this->cells[$coordinate->toString()] = [];
    }

    public function placeToken(Coordinate $coordinate, GameToken $token): void
    {
        $this->cells[$coordinate->toString()] = $token;
    }
}
