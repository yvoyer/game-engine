<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPUnit\Framework\TestCase;

final class IntegerValueTest extends TestCase
{
    public function test_it_should_convert_to_string(): void
    {
        self::assertSame('1', IntegerValue::fromInt(1)->toString());
    }
}
