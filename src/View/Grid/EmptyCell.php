<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use Star\GameEngine\Component\Token\GameToken;

final class EmptyCell implements GameToken
{
    public function toString(): string
    {
        return '';
    }
}
