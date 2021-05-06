<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPUnit\Framework\TestCase;

final class BooleanValueTest extends TestCase
{
    public function test_it_should_convert_to_string(): void
    {
        self::assertSame('1', BooleanValue::fromBoolean(true)->toString());
        self::assertSame('0', BooleanValue::fromBoolean(false)->toString());
    }
}
