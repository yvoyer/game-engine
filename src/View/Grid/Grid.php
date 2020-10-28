<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use Star\GameEngine\Component\Token\GameToken;
use Star\GameEngine\View\ViewRenderer;

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
}
