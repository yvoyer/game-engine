<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Stub;

use Star\GameEngine\Messaging\Event\GameEvent;

final class EventOccurred extends GameEvent
{
    /**
     * @var string
     */
    private $name;

    public function __construct(string $name)
    {
        $this->name = $name;
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
        return [
            'name' => $this->name,
        ];
    }
}
