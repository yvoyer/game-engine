<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use PHPUnit\Framework\TestCase;

final class FloatValueTest extends TestCase
{
    public function test_it_should_not_allow_to_cast_float_to_int(): void
    {
        $this->expectException(NotSupportedTypeConversion::class);
        $this->expectExceptionMessage('Conversion of value "float(12.34)" to "int()" is not supported.');
        FloatValue::fromFloat(12.34)->toInt();
    }

    public function test_it_should_not_allow_bool_conversion(): void
    {
        $this->expectException(NotSupportedTypeConversion::class);
        $this->expectExceptionMessage('Conversion of value "float(12.34)" to "bool()" is not supported.');
        FloatValue::fromFloat(12.34)->toBool();
    }
}
