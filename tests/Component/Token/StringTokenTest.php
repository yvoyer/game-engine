<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Token;

use PHPUnit\Framework\TestCase;

final class StringTokenTest extends TestCase
{
    public function test_it_should_return_the_string_token(): void
    {
        self::assertSame('token', StringToken::fromString('token')->toString());
    }
}
