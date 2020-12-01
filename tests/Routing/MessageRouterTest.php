<?php declare(strict_types=1);

namespace Star\GameEngine\Routing;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Messaging\GameMessage;
use Star\GameEngine\Messaging\HandlerNotFound;
use Star\GameEngine\Runner\MessageRunner;
use function get_class;

final class MessageRouterTest extends TestCase
{
    public function test_it_should_handle_message(): void
    {
        $message = $this->createMock(GameMessage::class);
        $runner = $this->createMock(MessageRunner::class);
        $runner
            ->expects($this->once())
            ->method('run');

        $router = new MessageRouter();
        $router->addHandler(get_class($message), function () {
        });

        $router->handle($message, $runner);
    }

    public function test_it_should_throw_exception_when_message_not_found(): void
    {
        $router = new MessageRouter();

        $this->expectException(HandlerNotFound::class);
        $this->expectExceptionMessage('No message handler was found for message');
        $router->handle(
            $this->createMock(GameMessage::class),
            $this->createMock(MessageRunner::class)
        );
    }
}
