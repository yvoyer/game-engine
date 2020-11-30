<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View;

interface ViewRenderer
{
    public function collectCellToken(Coordinate $coordinate, string $content): void;

    public function getDisplay(): string;
}
