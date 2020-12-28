<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Logging;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Testing\Stub\DoGameCommand;
use Star\GameEngine\Testing\Stub\EventSpy;

final class CollectMessagesTest extends TestCase
{
    public function test_it_should_collect_messages_when_notifying_a_listener(): void
    {
        $observer = new CollectMessages();
        self::assertSame([], $observer->getMessages());

        $observer->notifyListenerDispatch(
            function (): void {
            },
            new EventSpy('Something')
        );

        self::assertSame(
            [
                'Something occurred.'
            ],
            $observer->getMessages()
        );
    }

    public function test_it_should_collect_messages_when_notifying_command(): void
    {
        $observer = new CollectMessages();
        self::assertSame([], $observer->getMessages());

        $observer->notifyScheduleCommand(new DoGameCommand());

        self::assertSame(
            [
                'Someone did a command.'
            ],
            $observer->getMessages()
        );
    }
}
