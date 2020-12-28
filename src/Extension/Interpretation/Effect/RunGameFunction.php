<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Effect;

use Star\GameEngine\Messaging\GameCommand;

final class RunGameFunction implements GameCommand
{
    /**
     * @var string
     */
    private $function;

    public function __construct(string $function)
    {
        $this->function = $function;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function toString(): string
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function payload(): array
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
