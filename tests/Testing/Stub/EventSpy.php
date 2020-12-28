<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Stub;

use Star\GameEngine\Messaging\Event\GameEvent;

final class EventSpy extends GameEvent
{
    /**
    * @var string
    */
    private $name;

    /**
     * @var string[]
     */
    private $payload = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function addPayload(string $value): void
    {
        $this->payload[] = $value;
    }

    public function toString(): string
    {
        return $this->name . ' occurred.';
    }

    /**
     * @return mixed[]
     */
    public function payload(): array
    {
        $this->addPayload($this->toString());
        return $this->payload;
    }
}
