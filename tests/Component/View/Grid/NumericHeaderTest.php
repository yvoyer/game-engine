<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use PHPUnit\Framework\TestCase;

final class NumericHeaderTest extends TestCase
{
    public function test_it_should_return_number(): void
    {
        $strategy = new NumericHeader();
        self::assertSame('1', $strategy->generateId(1));
        self::assertSame('26', $strategy->generateId(26));
    }
}
