<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

final class GameEngineEvents
{
    /**
     * Event dispatched before a command is handled.
     *
     * @see CommandWasDispatched
     */
    const GAME_BEFORE_COMMAND = 'game_core.pre_command';

    /**
     * Event dispatched after a command was handled.
     *
     * @see CommandWasDispatched
     */
    const GAME_AFTER_COMMAND = 'game_core.post_command';

    /**
     * Event dispatched when a event is triggered.
     *
     * @see GameEvent
     */
    const GAME_EVENT = 'game_core.event';
}
