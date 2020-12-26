<?php declare(strict_types=1);

namespace Star\GameEngine\Routing;

use Star\GameEngine\GameVisitor;
use Star\GameEngine\Messaging\GameMessage;
use Star\GameEngine\Messaging\HandlerNotFound;
use Star\GameEngine\Runner\MessageRunner;
use function array_key_exists;
use function get_class;

final class MessageRouter
{
    /**
     * @var callable[]
     */
    private $handlers = [];

    public function addHandler(string $message, callable $handler): void
    {
        $this->handlers[$message] = $handler;
    }

    public function acceptGameVisitor(GameVisitor $visitor): void
    {
        foreach ($this->handlers as $message => $handler) {
            $visitor->visitCommandHandler($message, $handler);
        }
    }

    public function handle(GameMessage $message, MessageRunner $runner): void
    {
        $class = get_class($message);
        if (! array_key_exists($class, $this->handlers)) {
            throw new HandlerNotFound($class);
        }

        $handler = $this->handlers[$class];
        $runner->run($handler, $message);
    }
}
