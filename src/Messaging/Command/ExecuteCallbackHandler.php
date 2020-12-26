<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Command;

final class ExecuteCallbackHandler
{
    public function __invoke(ExecuteCallback $command): void
    {
        $callback = $command->callback();
        $callback();
    }
}
