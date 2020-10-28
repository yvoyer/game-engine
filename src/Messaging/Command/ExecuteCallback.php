<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Command;

use Star\GameEngine\Messaging\UserAction;

final class ExecuteCallback implements UserAction
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function callback(): callable
    {
        return $this->callback;
    }

    public function toString(): string
    {
        return 'Executing a callback.';
    }

    public function payload(): array
    {
        return [];
    }
}
