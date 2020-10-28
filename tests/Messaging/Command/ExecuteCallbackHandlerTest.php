<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Command;

use Exception;
use PHPUnit\Framework\TestCase;

final class ExecuteCallbackHandlerTest extends TestCase
{
    public function test_it_should_execute_callback(): void
    {
        $handler = new ExecuteCallbackHandler();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('pass');
        $handler(
            new ExecuteCallback(
                function () {
                    throw new Exception('pass');
                }
            )
        );
    }
}
