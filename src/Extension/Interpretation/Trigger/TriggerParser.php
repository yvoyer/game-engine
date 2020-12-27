<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

final class TriggerParser implements TriggerEffect
{
    public static function fromString(string $trigger): TriggerEffect
    {
        return new self();
    }
}
