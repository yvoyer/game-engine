<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use function strval;

final class NumericHeader implements HeaderIdStrategy
{
    public function generateId(int $position): string
    {
        return strval($position);
    }
}
