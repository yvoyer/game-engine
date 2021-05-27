<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\NotAllowedMethodCall;
use function sprintf;

final class BooleanValueTest extends TestCase
{
    public function test_it_should_convert_to_string(): void
    {
        self::assertSame('1', BooleanValue::fromBoolean(true)->toString());
        self::assertSame('0', BooleanValue::fromBoolean(false)->toString());
    }

    public function test_it_should_never_allow_to_call_to_list(): void
    {
        $value = BooleanValue::asFalse();
        self::assertFalse($value->isList());

        $this->expectException(NotAllowedMethodCall::class);
        $this->expectExceptionMessage(
            sprintf(
                'Not allowed to call method "%s::toList" when variable is boolean.',
                BooleanValue::class
            )
        );
        $value->toList();
    }
}
