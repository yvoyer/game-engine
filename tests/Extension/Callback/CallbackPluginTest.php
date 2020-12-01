<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Callback;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Testing\Stub\EngineSpy;

final class CallbackPluginTest extends TestCase
{
    public function test_it_should_attach_listeners(): void
    {
        $plugin = new CallbackPlugin(
            [
                'event' => function () {
                },
            ]
        );
        $plugin->attach($spy = new EngineSpy());

        self::assertCount(1, $spy->listeners);
        self::assertCount(0, $spy->handlers);
    }

    public function test_it_should_attach_handlers(): void
    {
        $plugin = new CallbackPlugin(
            [],
            [
                'event' => function () {
                },
            ]
        );
        $plugin->attach($spy = new EngineSpy());

        self::assertCount(0, $spy->listeners);
        self::assertCount(1, $spy->handlers);
    }
}
