<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\Prototyping\Type\InvalidAuthorizedChoices;
use stdClass;

final class ChoiceValueTest extends TestCase
{
    public function test_it_should_build_from_unknown_as_string(): void
    {
        $options = ChoiceValue::arrayOfUnknowns('one', 'two', 'three');
        self::assertSame('array(one;two;three)', $options->toTypedString());
        self::assertSame('one;two;three', $options->toString());
    }

    public function test_it_should_build_from_unknown_as_integer(): void
    {
        $options = ChoiceValue::arrayOfUnknowns(1, 2, 3);
        self::assertSame('array(1;2;3)', $options->toTypedString());
        self::assertSame('1;2;3', $options->toString());
    }

    public function test_it_should_build_from_unknown_as_float(): void
    {
        $options = ChoiceValue::arrayOfUnknowns(12.34, 56.78, 90.12);
        self::assertSame('array(12.34;56.78;90.12)', $options->toTypedString());
        self::assertSame('12.34;56.78;90.12', $options->toString());
    }

    /**
     * @param mixed $value
     * @param string $expected
     * @dataProvider provideNotSupportedValues
     */
    public function test_it_should_throw_exception_when_unknown_types_not_supported($value, string $expected): void
    {
        $this->expectException(InvalidAuthorizedChoices::class);
        $this->expectExceptionMessage(\sprintf('Choices with values of type "%s" are not supported yet.', $expected));
        ChoiceValue::arrayOfUnknowns($value);
    }

    public static function provideNotSupportedValues(): array
    {
        return [
            [array(), 'array'],
            [new stdClass(), 'stdClass'],
            [true, 'boolean'],
            [false, 'boolean'],
            [null, 'NULL'],
            [function () {}, 'Closure'],
        ];
    }
}
