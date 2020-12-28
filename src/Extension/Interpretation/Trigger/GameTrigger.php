<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

use Star\GameEngine\Engine;

final class GameTrigger
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

    public function attachToEngine(
        Engine $engine,
        int $priority
    ): void {
        $engine->addListener(
            $this->frequency->toString(),
            function () use ($engine): void {
                $result = $engine->dispatchQuery($this->condition);

                if ($result->toBool()) {
                    $this->effect->execute($engine);
                }
            },
            $priority
        );
    }
}
