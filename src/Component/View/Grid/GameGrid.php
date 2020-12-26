<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use Star\GameEngine\Component\Token\GameToken;
use Star\GameEngine\Component\View\Coordinate;
use Star\GameEngine\Component\View\ViewRenderer;

interface GameGrid
{
    /**
     * @param Coordinate $coordinate
     * @param GameToken $token
     */
    public function placeToken(Coordinate $coordinate, GameToken $token): void;

    public function acceptGridVisitor(GridVisitor $visitor): void;

    public function render(ViewRenderer $renderer): void;
}
