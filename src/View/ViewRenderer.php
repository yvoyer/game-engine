<?php declare(strict_types=1);

namespace Star\GameEngine\View;

use Star\GameEngine\View\Grid\Coordinate;

interface ViewRenderer
{
    public function collectCellToken(Coordinate $coordinate, string $content): void;

    public function getDisplay(): string;
}
