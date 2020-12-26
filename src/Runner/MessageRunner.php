<?php declare(strict_types=1);

namespace Star\GameEngine\Runner;

use Star\GameEngine\Messaging\GameMessage;

interface MessageRunner
{
    public function run(callable $handler, GameMessage $message): void;
}
