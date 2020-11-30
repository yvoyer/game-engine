<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use Star\GameEngine\Component\Token\GameToken;
use Star\GameEngine\Component\View\Coordinate;
use Star\GameEngine\Component\View\ViewRenderer;

final class Grid implements GameGrid
{
    /**
     * @var GameToken[]
     */
    private $cells = [];

    public function placeToken(Coordinate $coordinate, GameToken $token): void
    {
        $this->cells[$coordinate->toString()] = $token;
    }

    public function render(ViewRenderer $renderer): void {
        foreach ($this->cells as $coordinate => $token) {
            $renderer->collectCellToken(
                Coordinate::fromString($coordinate),
                $token->toString()
            );
        }
    }

    public function acceptGridVisitor(GridVisitor $visitor): void
    {
        $visitor->enterGrid();
        foreach ($this->cells as $coordinate => $token) {
            $visitor->visitTokenAtCoordinate(Coordinate::fromString($coordinate), $token);
        }
    }
}
