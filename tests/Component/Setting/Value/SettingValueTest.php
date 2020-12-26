<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Setting\SettingValue;

final class SettingValueTest extends TestCase
{
    /**
     * @dataProvider provideSupportedStringCast
     *
     * @param string $expected
     * @param mixed $rawValue
     */
    final public function test_supported_value_is_castable_to_string(string $expected, $rawValue): void
    {
        $value = $this->createValue($rawValue);
        self::assertSame($expected, $value->toString());
    }

    /**
     * @return array[]
     */
    public static function provideSupportedStringCast(): array
    {
        return [
            ['value', 'value'],
            ['123', 123],
            ['1.23', 1.23],
            ['1', true],
            ['0', false],
            ['0', '0'],
            ['123', '123'],
            ['1.23', '1.23'],
        ];
    }

    /**
     * @dataProvider provideSupportedIntCast
     *
     * @param int $expected
     * @param mixed $rawValue
     */
    final public function test_supported_value_is_castable_to_int(int $expected, $rawValue): void
    {
        $value = $this->createValue($rawValue);
        self::assertSame($expected, $value->toInt());
    }

    /**
     * @return array[]
     */
    public static function provideSupportedIntCast(): array
    {
        return [
            [123, '123'],
            [123, 123],
            [1, true],
            [0, false],
            [0, '0'],
        ];
    }

    /**
     * @dataProvider provideSupportedBooleanCast
     *
     * @param bool $expected
     * @param mixed $rawValue
     */
    final public function test_supported_value_is_castable_to_bool(bool $expected, $rawValue): void
    {
        $value = $this->createValue($rawValue);
        self::assertSame($expected, $value->toBool());
    }

    /**
     * @return array[]
     */
    public static function provideSupportedBooleanCast(): array
    {
        return [
            [true, true],
            [false, false],
        ];
    }

    /**
     * @dataProvider provideSupportedFloatCast
     *
     * @param float $expected
     * @param mixed $rawValue
     */
    final public function test_supported_value_is_castable_to_float(float $expected, $rawValue): void
    {
        $value = $this->createValue($rawValue);
        self::assertSame($expected, $value->toFloat());
    }

    /**
     * @return array[]
     */
    public static function provideSupportedFloatCast(): array
    {
        return [
            [123.0, '123'],
            [123, 123],
            [1.23, '1.23'],
            [1.23, 1.23],
            [0, '0'],
        ];
    }

    /**
     * @param mixed $value
     * @return SettingValue
     */
    final private function createValue($value): SettingValue
    {
        return TypeGuesser::fromMixed($value);
    }
}
