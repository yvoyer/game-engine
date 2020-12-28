<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

final class TriggerFrequency
{
    /**
     * @var string
     */
    private $eventName;

    public function __construct(string $eventName)
    {
        $this->eventName = $eventName;
    }

    public function toString(): string
    {
        return $this->eventName;
    }
}
