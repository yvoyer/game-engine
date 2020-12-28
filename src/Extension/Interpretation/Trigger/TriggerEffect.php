<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

use Star\GameEngine\Engine;

interface TriggerEffect
{
    /**
     * @param Engine $engine
     */
    public function execute(Engine $engine): void;
}
