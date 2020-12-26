<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use PHPUnit\Framework\TestCase;
use function sprintf;

final class BoolResultTest extends TestCase
{
    public function test_it_should_not_support_string_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "string" is not supported.',
                BoolResult::class
            )
        );
        BoolResult::asFalse()->toString();
    }

    public function test_it_should_not_support_int_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "int" is not supported.',
                BoolResult::class
            )
        );
        BoolResult::asFalse()->toInt();
    }

    public function test_it_should_not_support_float_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "float" is not supported.',
                BoolResult::class
            )
        );
        BoolResult::asFalse()->toFloat();
    }

    public function test_it_should_not_support_array_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "array" is not supported.',
                BoolResult::class
            )
        );
        BoolResult::asFalse()->toArray();
    }

    public function test_it_should_not_support_object_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "object" is not supported.',
                BoolResult::class
            )
        );
        BoolResult::asFalse()->toObject();
    }

    public function test_it_should_return_bool_result(): void
    {
        self::assertTrue(BoolResult::asTrue()->toBool());
        self::assertFalse(BoolResult::asFalse()->toBool());
    }
}
