<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPUnit\Framework\TestCase;

final class StringValueTest extends TestCase
{
    public function test_it_should_convert_to_string(): void
    {
        self::assertSame('value', StringValue::fromString('value')->toString());
    }
}

