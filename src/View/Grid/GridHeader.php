<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

interface GridHeader
{
    /**
     * @return int The number of header for this axis
     */
    public function maximumCount(): int;

    /**
     * @param int $position The position of the header, starting at 1.
     * @return string
     */
    public function generateId(int $position): string;
}
