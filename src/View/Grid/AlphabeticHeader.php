<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use function chr;

final class AlphabeticHeader implements GridHeader
{
    /**
     * @var int
     */
    private $count;

    public function __construct(int $count)
    {
        $this->count = $count;
    }

    public function maximumCount(): int
    {
        return $this->count;
    }

    public function generateId(int $position): string
    {
        return chr(64 + $position); // 65:A => 90:Z
    }
}
