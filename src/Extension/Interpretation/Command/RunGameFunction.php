<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Command;

use Star\GameEngine\Messaging\GameCommand;

final class RunGameFunction implements GameCommand
{
    /**
     * @var string
     */
    private $function;

    /**
     * @var mixed
     */
    private $arguments;

    public function __construct(string $function, array $arguments = [])
    {
        $this->function = $function;
        $this->arguments = $arguments;
    }

    public function getFunction(): string
    {
        return $this->function;
    }

    public function getArguments(): array
    {
        return $this->arguments;
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
