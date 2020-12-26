<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

/**
 * Action that perform something in the game.
 */
interface GameCommand extends GameMessage
{
    /**
     * Return the human-readable representation of the command.
     *
     * @return string
     */
    public function toString(): string;

    /**
     * @return mixed[]
     */
    public function payload(): array;
}
