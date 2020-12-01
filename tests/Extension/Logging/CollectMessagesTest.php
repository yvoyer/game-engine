<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Logging;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Testing\Stub\EventSpy;

final class CollectMessagesTest extends TestCase
{
    public function test_it_should_collect_messages(): void
    {
        $observer = new CollectMessages();
        self::assertSame([], $observer->getMessages());

        $observer->notifyListenerDispatch(function () {
        }, new EventSpy('Something'));

        self::assertSame(
            [
                'Something occurred.'
            ],
            $observer->getMessages()
        );
    }
}
