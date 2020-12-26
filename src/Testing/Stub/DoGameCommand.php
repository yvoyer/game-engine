<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Stub;

use Star\GameEngine\Messaging\GameCommand;

final class DoGameCommand implements GameCommand
{
    public function toString(): string
    {
        return 'Someone did a command.';
    }

    /**
     * @return mixed[]
     */
    public function payload(): array
    {
        return [];
    }
}
