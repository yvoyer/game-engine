<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use PHPUnit\Framework\TestCase;

final class MessageLookupTest extends TestCase
{
    public function test_return_whether_a_command_was_visited(): void
    {
        $visitor = new MessageLookup();

        self::assertFalse($visitor->isRegistered('name'));

        $visitor->visitCommandHandler('name', function () {
        });

        self::assertTrue($visitor->isRegistered('name'));
    }

    public function test_return_whether_a_query_was_visited(): void
    {
        $visitor = new MessageLookup();

        self::assertFalse($visitor->isRegistered('name'));

        $visitor->visitQueryHandler('name', function () {
        });

        self::assertTrue($visitor->isRegistered('name'));
    }

    public function test_return_whether_a_listener_was_visited(): void
    {
        $visitor = new MessageLookup();

        self::assertFalse($visitor->isRegistered('name'));

        $visitor->visitListener('name', 'listener');

        self::assertTrue($visitor->isRegistered('name'));
    }
}
