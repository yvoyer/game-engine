<?php declare(strict_types=1);

namespace Star\GameEngine\Runner;

use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\GameMessage;
use Webmozart\Assert\Assert;

final class CommandRunner implements MessageRunner
{
    public function run(callable $handler, GameMessage $message): void
    {
        Assert::isInstanceOf($message, GameCommand::class);
        $handler($message);
    }
}
