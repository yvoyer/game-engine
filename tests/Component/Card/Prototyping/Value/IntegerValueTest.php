<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\NotAllowedMethodCall;

final class IntegerValueTest extends TestCase
{
    public function test_it_should_convert_to_string(): void
    {
        self::assertSame('1', IntegerValue::fromInt(1)->toString());
    }

    public function test_it_should_never_allow_to_call_to_list(): void
    {
        $value = IntegerValue::fromInt(34);
        self::assertFalse($value->isList());

        $this->expectException(NotAllowedMethodCall::class);
        $this->expectExceptionMessage(
            sprintf(
                'Not allowed to call method "%s::toList" when variable is integer.',
                IntegerValue::class
            )
        );
        $value->toList();
    }
}
