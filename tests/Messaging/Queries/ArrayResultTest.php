<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use DateTimeInterface;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ArrayResultTest extends TestCase
{
    public function test_return_result_as_array(): void
    {
        $result = new ArrayResult([]);
        self::assertSame([], $result->toArray());

        $result = new ArrayResult([1, 2, 3]);
        self::assertSame([1, 2, 3], $result->toArray());
    }

    public function test_throw_exception_when_array_do_not_contains_correct_instances(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected a collection of instances of "DateTimeInterface". Got: "stdClass".');
        ArrayResult::allInstanceOf(DateTimeInterface::class, [(object) []]);
    }

    public function test_should_not_support_bool_return_type(): void
    {
        $result = new ArrayResult([]);

        $this->expectException(NotSupportedResultConversion::class);
        $result->toBool();
    }

    public function test_should_not_support_int_return_type(): void
    {
        $result = new ArrayResult([]);

        $this->expectException(NotSupportedResultConversion::class);
        $result->toInt();
    }

    public function test_should_not_support_float_return_type(): void
    {
        $result = new ArrayResult([]);

        $this->expectException(NotSupportedResultConversion::class);
        $result->toFloat();
    }

    public function test_should_not_support_string_return_type(): void
    {
        $result = new ArrayResult([]);

        $this->expectException(NotSupportedResultConversion::class);
        $result->toString();
    }

    public function test_should_not_support_object_return_type(): void
    {
        $result = new ArrayResult([]);

        $this->expectException(NotSupportedResultConversion::class);
        $result->toObject();
    }

    public function test_should_not_support_array_of_instances(): void
    {
        self::assertSame(
            [],
            ArrayResult::allInstanceOf(DateTimeInterface::class, [])->toArray()
        );
    }
}
