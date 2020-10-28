<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use PHPUnit\Framework\TestCase;

final class StringValueTest extends TestCase
{
    public function test_it_should_not_allow_bool_conversion(): void
    {
        $this->expectException(NotSupportedTypeConversion::class);
        $this->expectExceptionMessage('Conversion of value "string(string)" to "bool()" is not supported.');
        StringValue::fromString('string')->toBool();
    }

    public function test_it_should_not_allow_float_conversion(): void
    {
        $this->expectException(NotSupportedTypeConversion::class);
        $this->expectExceptionMessage('Conversion of value "string(string)" to "float()" is not supported.');
        StringValue::fromString('string')->toFloat();
    }

    public function test_it_should_not_allow_int_conversion(): void
    {
        $this->expectException(NotSupportedTypeConversion::class);
        $this->expectExceptionMessage('Conversion of value "string(string)" to "int()" is not supported.');
        StringValue::fromString('string')->toInt();
    }
}
