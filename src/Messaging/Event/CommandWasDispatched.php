<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

use Star\GameEngine\Messaging\GameCommand;
use Symfony\Contracts\EventDispatcher\Event;

final class CommandWasDispatched extends Event
{
    /**
     * @var GameCommand
     */
    private $command;

    public function __construct(GameCommand $command)
    {
        $this->command = $command;
    }

    public function command(): GameCommand
    {
        return $this->command;
    }

    public function messageName(): string
    {
        return GameEngineEvents::GAME_AFTER_COMMAND;
    }
}
