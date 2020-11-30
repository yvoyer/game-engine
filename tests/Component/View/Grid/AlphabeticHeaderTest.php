<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View\Grid;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class AlphabeticHeaderTest extends TestCase
{
    public function test_it_should_return_single_chars(): void
    {
        $strategy = new AlphabeticHeader();
        self::assertSame('A', $strategy->generateId(1));
        self::assertSame('Z', $strategy->generateId(26));
    }

    public function test_it_should_throw_exception_when_too_low(): void
    {
        $strategy = new AlphabeticHeader();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Alphabetic header position "0" must be between "1" and "26".');
        $strategy->generateId(0);
    }

    public function test_it_should_throw_exception_when_too_high(): void
    {
        $strategy = new AlphabeticHeader();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Alphabetic header position "27" must be between "1" and "26".');
        $strategy->generateId(27);
    }
}
