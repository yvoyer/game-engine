<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

interface HeaderIdStrategy
{
    /**
     * @param int $position The position of the header, starting at 1.
     * @return string
     */
    public function generateId(int $position): string;
}
