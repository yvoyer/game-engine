<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

use Star\GameEngine\Extension\Interpretation\GameTrigger;

final class TriggerReference implements GameTrigger
{
    /**
     * @var TriggerCondition
     */
    private $condition;

    /**
     * @var TriggerEffect
     */
    private $effect;

    /**
     * @var TriggerFrequency
     */
    private $frequency;

    /**
     * @var TriggerDescription
     */
    private $description;

    public function __construct(
        TriggerCondition $condition,
        TriggerEffect $effect,
        TriggerFrequency $frequency,
        TriggerDescription $description
    ) {
        $this->condition = $condition;
        $this->effect = $effect;
        $this->frequency = $frequency;
        $this->description = $description;
    }
}
