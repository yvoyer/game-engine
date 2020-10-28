<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use function strval;

final class NumericHeader implements GridHeader
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
        return strval($position);
    }
}
