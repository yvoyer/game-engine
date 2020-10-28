<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

use Star\Component\DomainEvent\DomainEvent;
use Symfony\Contracts\EventDispatcher\Event;

abstract class GameEvent extends Event implements DomainEvent
{
    abstract public function toString(): string;

    final public function messageName(): string
    {
        return GameEngineEvents::GAME_EVENT;
    }

    abstract public function payload(): array;
}
