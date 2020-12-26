<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use Star\GameEngine\Component\Token\GameToken;
use Star\GameEngine\Component\View\Coordinate;

interface GridVisitor
{
    public function enterGrid(): void;

    public function visitTokenAtCoordinate(Coordinate $coordinate, GameToken $token): void;
}
