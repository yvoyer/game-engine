<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class PlaceholderDataTest extends TestCase
{
    public function test_it_should_return_the_string_value(): void
    {
        $data = PlaceholderData::fromArray(['key' => 'value']);
        self::assertSame('value', $data->getStringValue('key'));
    }

    public function test_it_should_return_the_integer_value(): void
    {
        $data = PlaceholderData::fromArray(['key' => 123]);
        self::assertSame(123, $data->getIntegerValue('key'));
        self::assertSame('123', $data->getStringValue('key'));
    }

    public function test_it_should_return_the_boolean_value(): void
    {
        $data = PlaceholderData::fromArray(['key' => true]);
        self::assertTrue($data->getBooleanValue('key'));

        $data = PlaceholderData::fromArray(['key' => false]);
        self::assertFalse($data->getBooleanValue('key'));
    }

    public function test_it_should_not_allow_to_return_non_integer(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value "12.34" for key "key" is not castable to integer.');
        PlaceholderData::fromArray(['key' => 12.34])->getIntegerValue('key');
    }

    /**
     * @param mixed $value
     * @param string $expected
     * @dataProvider provideNotSupportedValues
     */
    public function test_it_should_not_allow_to_be_built_with_non_scalar($value, string $expected): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage($expected);
        PlaceholderData::fromArray(['key' => $value]);
    }

    public static function provideNotSupportedValues(): array
    {
        return [
            [null, 'Value "<NULL>" is null, but non null value was expected.'],
            [[], 'Value "<ARRAY>" is not a scalar.'],
            [(object) [], 'Value "stdClass" is not a scalar.'],
        ];
    }

    public function test_it_should_throw_exception_when_key_do_not_exists_for_boolean_value(): void
    {
        $this->expectException(MissingPlaceholderValue::class);
        $this->expectExceptionMessage(
            'The placeholder with name "key", requires a value to be given in the data, "[]" given.'
        );
        PlaceholderData::noData()->getBooleanValue('key');
    }

    public function test_it_should_throw_exception_when_key_do_not_exists_for_integer_value(): void
    {
        $this->expectException(MissingPlaceholderValue::class);
        $this->expectExceptionMessage(
            'The placeholder with name "key", requires a value to be given in the data, "[]" given.'
        );
        PlaceholderData::noData()->getIntegerValue('key');
    }

    public function test_it_should_throw_exception_when_key_do_not_exists_for_string_value(): void
    {
        $this->expectException(MissingPlaceholderValue::class);
        $this->expectExceptionMessage(
            'The placeholder with name "key", requires a value to be given in the data, "[]" given.'
        );
        PlaceholderData::noData()->getStringValue('key');
    }
}
