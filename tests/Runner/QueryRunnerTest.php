<?php declare(strict_types=1);

namespace Star\GameEngine\Runner;

use Exception;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Star\GameEngine\Messaging\GameMessage;
use Star\GameEngine\Messaging\GameQuery;

final class QueryRunnerTest extends TestCase
{
    public function test_it_should_throw_exception_when_not_a_command(): void
    {
        $runner = new QueryRunner();
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Expected an instance of Star\GameEngine\Messaging\GameQuery. Got:');
        $runner->run(function () {}, $this->createMock(GameMessage::class));
    }

    public function test_it_should_execute_command(): void
    {
        $runner = new QueryRunner();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('pass');
        $runner->run(
            function () {
                throw new Exception('pass');
            },
            $this->createMock(GameQuery::class)
        );
    }
}
