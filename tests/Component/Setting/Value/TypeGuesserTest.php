<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class TypeGuesserTest extends TestCase
{
    /**
     * @param class-string $type
     * @param mixed $raw
     *
     * @dataProvider provideValues
     */
    public function test_it_should_guess_type(string $type, $raw): void
    {
        self::assertInstanceOf($type, TypeGuesser::fromMixed($raw));
    }

    /**
     * @return array[]
     */
    public static function provideValues(): array
    {
        return [
            [StringValue::class, 'value'],
            [IntegerValue::class, '123'],
            [FloatValue::class, '12.34'],
            [IntegerValue::class, '1'],
            [IntegerValue::class, '0'],
            [IntegerValue::class, 123],
            [FloatValue::class, 12.34],
            [IntegerValue::class, 1],
            [IntegerValue::class, 0],
            [BoolValue::class, true],
            [BoolValue::class, false],
        ];
    }

    public function test_it_should_throw_exception_when_not_supported_type(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value type "array" cannot be guessed.');
        TypeGuesser::fromMixed([]);
    }
}
