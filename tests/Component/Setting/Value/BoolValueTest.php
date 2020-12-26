<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use PHPUnit\Framework\TestCase;

final class BoolValueTest extends TestCase
{
    public function test_it_should_not_allow_float_conversion(): void
    {
        $this->expectException(NotSupportedTypeConversion::class);
        $this->expectExceptionMessage('Conversion of value "boolean(1)" to "float()" is not supported.');
        BoolValue::fromBool(true)->toFloat();
    }
}
