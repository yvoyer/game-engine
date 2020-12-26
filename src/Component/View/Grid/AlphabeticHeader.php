<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use Assert\Assertion;
use function chr;

final class AlphabeticHeader implements HeaderIdStrategy
{
    public function generateId(int $position): string
    {
        Assertion::between(
            $position,
            1,
            26,
            'Alphabetic header position "%s" must be between "%s" and "%s".'
        );
        return chr(64 + $position); // 65:A => 90:Z
    }
}
