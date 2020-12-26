<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use PHPUnit\Framework\TestCase;
use function sprintf;

final class IntResultTest extends TestCase
{
    public function test_it_should_not_allow_bool_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "bool" is not supported.',
                IntResult::class
            )
        );
        IntResult::fromInt(123)->toBool();
    }

    public function test_it_should_not_allow_array_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "array" is not supported.',
                IntResult::class
            )
        );
        IntResult::fromInt(123)->toArray();
    }

    public function test_it_should_not_allow_object_type(): void
    {
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "object" is not supported.',
                IntResult::class
            )
        );
        IntResult::fromInt(123)->toObject();
    }

    public function test_it_should_allow_converting_to_string(): void
    {
        self::assertSame('123', IntResult::fromInt(123)->toString());
    }

    public function test_it_should_allow_converting_to_float(): void
    {
        self::assertSame(123.0, IntResult::fromInt(123)->toFloat());
    }
}
