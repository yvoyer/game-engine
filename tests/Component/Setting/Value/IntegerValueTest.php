<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use PHPUnit\Framework\TestCase;

final class IntegerValueTest extends TestCase
{
    public function test_it_should_not_allow_to_cast_to_bool(): void
    {
        $this->expectException(NotSupportedTypeConversion::class);
        $this->expectExceptionMessage('Conversion of value "integer(1)" to "bool()" is not supported.');
        IntegerValue::fromInt(1)->toBool();
    }
}
