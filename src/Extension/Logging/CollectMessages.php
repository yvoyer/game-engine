<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Logging;

use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;

final class CollectMessages implements EngineObserver
{
    const LOG_LISTENER = 1;
    const LOG_COMMAND = 2;
    const LOG_ALL = self::LOG_LISTENER | self::LOG_COMMAND;

    /**
     * @var string[]
     */
    private $messages = [];

    /**
     * @var int
     */
    private $level;

    public function __construct(int $level = self::LOG_ALL)
    {
        $this->level = $level;
    }

    public function notifyListenerDispatch(callable $listener, GameEvent $event): void
    {
        if (($this->level & self::LOG_LISTENER) === self::LOG_LISTENER) {
            $this->messages[] = $event->toString();
        }
    }

    public function notifyScheduleCommand(GameCommand $command): void
    {
        if (($this->level & self::LOG_COMMAND) === self::LOG_COMMAND) {
            $this->messages[] = $command->toString();
        }
    }

    /**
     * @return string[]
     */
    public function getMessages(): array
    {
        return $this->messages;
    }
}
