<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Testing\Stub\EventSpy;

final class ObserverIteratorTest extends TestCase
{
    public function test_it_should_notify_dispatch_of_listener(): void
    {
        $observer = $this->createMock(EngineObserver::class);
        $observer
            ->expects(self::once())
            ->method('notifyListenerDispatch');

        $iterator = new ObserverIterator($observer);
        $iterator->notifyListenerDispatch(
            function (): void {
            },
            new EventSpy('name')
        );
    }
}
