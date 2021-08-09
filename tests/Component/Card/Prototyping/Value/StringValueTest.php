<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\NotAllowedMethodCall;

final class StringValueTest extends TestCase
{
    public function test_it_should_convert_to_string(): void
    {
        self::assertSame('value', StringValue::fromString('value')->toString());
    }

    public function test_it_should_never_allow_to_call_to_list(): void
    {
        $value = StringValue::fromString('value');
        self::assertFalse($value->isList());

        $this->expectException(NotAllowedMethodCall::class);
        $this->expectExceptionMessage(
            sprintf(
                'Not allowed to call method "%s::toList" when variable is string.',
                StringValue::class
            )
        );
        $value->toList();
    }
}
