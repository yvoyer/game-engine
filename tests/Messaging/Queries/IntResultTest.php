<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use PHPUnit\Framework\TestCase;
use function sprintf;
use function ucfirst;

final class IntResultTest extends TestCase
{
    /**
     * @param string $type
     * @dataProvider provideNotSupportedTypes
     */
    public function test_it_should_only_support_bool_type(string $type): void
    {
        $method = 'to' . ucfirst($type);
        $this->expectException(NotSupportedResultConversion::class);
        $this->expectExceptionMessage(
            sprintf(
                'Conversion of result from "%s" to "%s" is not supported.',
                IntResult::class,
                $type
            )
        );
        IntResult::fromInt(123)->{$method}();
    }

    public static function provideNotSupportedTypes(): array
    {
        return [
            ['bool'],
            ['array'],
            ['object'],
        ];
    }

    public function test_it_should_allow_converting_to_string(): void
    {
        $this->assertSame('123', IntResult::fromInt(123)->toString());
    }

    public function test_it_should_allow_converting_to_float(): void
    {
        $this->assertSame(123.0, IntResult::fromInt(123)->toFloat());
    }
}
