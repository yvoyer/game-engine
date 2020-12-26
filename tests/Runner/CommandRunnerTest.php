<?php declare(strict_types=1);

namespace Star\GameEngine\Runner;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\GameMessage;

final class CommandRunnerTest extends TestCase
{
    public function test_it_should_throw_exception_when_not_a_command(): void
    {
        $runner = new CommandRunner();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected an instance of Star\GameEngine\Messaging\GameCommand. Got:');
        $runner->run(
            function (): void {
            },
            $this->createMock(GameMessage::class)
        );
    }

    public function test_it_should_execute_command(): void
    {
        $runner = new CommandRunner();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('pass');
        $runner->run(
            function (): void {
                throw new Exception('pass');
            },
            $this->createMock(GameCommand::class)
        );
    }
}
