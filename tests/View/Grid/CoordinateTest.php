<?php declare(strict_types=1);

namespace Star\GameEngine\View\Grid;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class CoordinateTest extends TestCase
{
    public function test_return_as_strings(): void
    {
        self::assertSame('x,y', Coordinate::fromStrings('x', 'y')->toString());
    }

    public function test_return_as_string(): void
    {
        self::assertSame('x,y', Coordinate::fromString('x,y')->toString());
    }

    /**
     * @dataProvider provideInvalidString
     * @param string $string
     * @param string $message
     */
    public function test_it_should_throw_exception_when_string_is_invalid_format(string $string, string $message): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($message);
        Coordinate::fromString($string);
    }

    public static function provideInvalidString(): array
    {
        return [
            ['x', 'Coordinate "x" is not a valid format, expected "x,y".'],
            [',', 'X-axis "" is empty, but non empty value was expected.'],
            ['x,', 'Y-axis "" is empty, but non empty value was expected.'],
            [',y', 'X-axis "" is empty, but non empty value was expected.'],
        ];
    }
}
