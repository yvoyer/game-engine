<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Callback;

use Star\GameEngine\Engine;
use Star\GameEngine\Extension\GamePlugin;

final class CallbackPlugin implements GamePlugin
{
    /**
     * @var callable[]
     */
    private $listeners;

    /**
     * @var callable[]
     */
    private $handlers;

    /**
     * @param callable[] $listeners
     * @param callable[] $handlers
     */
    public function __construct(array $listeners = [], array $handlers = [])
    {
        $this->listeners = $listeners;
        $this->handlers = $handlers;
    }

    public function attach(Engine $engine): void
    {
        foreach ($this->listeners as $name => $callback) {
            $engine->addListener($name, $callback, 500);
        }

        foreach ($this->handlers as $name => $callback) {
            $engine->addHandler($name, $callback);
        }
    }
}
