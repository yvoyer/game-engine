<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use PHPUnit\Framework\TestCase;
use function sprintf;

final class StringResultTest extends TestCase
{
    public function test_it_should_not_support_bool_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "bool" is not supported.',
                StringResult::class
            )
        );
        StringResult::fromString('value')->toBool();
    }

    public function test_it_should_not_support_int_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "int" is not supported.',
                StringResult::class
            )
        );
        StringResult::fromString('value')->toInt();
    }

    public function test_it_should_not_support_float_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "float" is not supported.',
                StringResult::class
            )
        );
        StringResult::fromString('value')->toFloat();
    }

    public function test_it_should_not_support_array_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "array" is not supported.',
                StringResult::class
            )
        );
        StringResult::fromString('value')->toArray();
    }

    public function test_it_should_not_support_object_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "object" is not supported.',
                StringResult::class
            )
        );
        StringResult::fromString('value')->toObject();
    }

    public function test_it_should_allow_converting_to_string(): void
    {
        self::assertSame('val', StringResult::fromString('val')->toString());
    }
}
