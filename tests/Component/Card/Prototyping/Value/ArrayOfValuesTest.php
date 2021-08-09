<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use PHPStan\Testing\TestCase;

final class ArrayOfValuesTest extends TestCase
{
    public function test_it_should_be_considered_a_list(): void
    {
        $value = ArrayOfValues::arrayOfStrings('one');
        self::assertTrue($value->isList());
        self::assertSame(['one'], $value->toList());
    }
}
