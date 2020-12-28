<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Effect;

use Star\GameEngine\Engine;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerEffect;

final class DispatchFunction implements TriggerEffect
{
    /**
     * @var string
     */
    private $functionCall;

    public function __construct(string $functionCall)
    {
        $this->functionCall = $functionCall;
    }

    public function execute(Engine $engine): void
    {
        $engine->dispatchCommand(new RunGameFunction($this->functionCall));
    }
}
