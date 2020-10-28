<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

interface GridFactory
{
    public function createGrid(): GameGrid;
}
