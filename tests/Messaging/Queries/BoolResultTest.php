<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use PHPUnit\Framework\TestCase;
use function sprintf;
use function ucfirst;

final class BoolResultTest extends TestCase
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
                BoolResult::class,
                $type
            )
        );
        BoolResult::asFalse()->{$method}();
    }

    public static function provideNotSupportedTypes(): array
    {
        return [
            ['string'],
            ['int'],
            ['float'],
            ['array'],
            ['object'],
        ];
    }

    public function test_it_should_return_bool_result(): void
    {
        $this->assertTrue(BoolResult::asTrue()->toBool());
        $this->assertFalse(BoolResult::asFalse()->toBool());
    }
}
