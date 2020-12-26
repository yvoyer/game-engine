<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

use PHPUnit\Framework\TestCase;

final class ArrayMapContextTest extends TestCase
{
    public function test_should_set_context(): void
    {
        $map = new ArrayMapContext();
        $map->updateContext('name', $context = $this->createMock(GameContext::class));

        self::assertTrue($map->hasContext('name'));
        self::assertSame($context, $map->getContext('name'));
    }

    public function test_should_throw_exception_when_context_not_found(): void
    {
        $map = new ArrayMapContext();
        self::assertFalse($map->hasContext('name'));

        $this->expectException(GameContextNotFound::class);
        $this->expectExceptionMessage('The game context "name" could not be found.');
        $map->getContext('name');
    }
}
