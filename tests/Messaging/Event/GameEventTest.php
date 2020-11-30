<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Testing\Stub\EventSpy;

final class GameEventTest extends TestCase
{
    public function test_should_return_the_message_name(): void
    {
        $event = new EventSpy('name');
        self::assertSame('event-spy', $event->messageName());
    }
}
