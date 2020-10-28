<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use PHPUnit\Framework\TestCase;

final class ArrayResultTest extends TestCase
{
    public function test_return_result_as_array(): void
    {
        $result = new ArrayResult([]);
        $this->assertSame([], $result->toArray());

        $result = new ArrayResult([1, 2, 3]);
        $this->assertSame([1, 2, 3], $result->toArray());
    }

    /**
     * @dataProvider provideNotSupportedMethods
     * @param string $method
     */
    public function test_should_not_support_return_type(string $method): void
    {
        $result = new ArrayResult([]);

        $this->expectException(NotSupportedResultConversion::class);
        $result->{$method}();
    }

    public static function provideNotSupportedMethods(): array
    {
        return [
            ['toBool'],
            ['toString'],
            ['toInt'],
            ['toFloat'],
            ['toObject'],
        ];
    }
}
