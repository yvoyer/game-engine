<?php declare(strict_types=1);

namespace Star\GameEngine;

use Closure;
use Star\GameEngine\Context\ArrayMapContext;
use Star\GameEngine\Context\ContextBuilder;
use Star\GameEngine\Context\ContextRegistry;
use Star\GameEngine\Context\GameContext;
use Star\GameEngine\Context\GameContextNotFound;
use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\Messaging\DuplicateListenerForEvent;
use Star\GameEngine\Messaging\DuplicatePriorityForEventListener;
use Star\GameEngine\Messaging\EngineObserver;
use Star\GameEngine\Messaging\Event;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\Queries\QueryResult;
use Star\GameEngine\Result\GameResult;
use Star\GameEngine\Routing\MessageRouter;
use Star\GameEngine\Runner\CommandRunner;
use Star\GameEngine\Runner\QueryRunner;
use function array_search;
use function get_class;

final class GameEngine implements Engine, ContextRegistry
{
    /**
     * @var GamePlugin[]
     */
    private $plugins = [];

    /**
     * @var Event\GameEventDispatcher
     */
    private $dispatcher;

    /**
     * @var MessageRouter
     */
    private $router;

    /**
     * @var ContextRegistry
     */
    private $contexts;

    /**
     * @var string[][]
     */
    private $listenerPriorities = [];

    public function __construct()
    {
        $this->dispatcher = new Event\GameEventDispatcher($this);
        $this->router = new MessageRouter();
        $this->contexts = new ArrayMapContext();
    }

    public function addListener(string $eventName, callable $callable, int $priority): void
    {
        if (! isset($this->listenerPriorities[$eventName])) {
            $this->listenerPriorities[$eventName] = [];
        }

        $callableClass = get_class($callable);
        foreach ($this->listenerPriorities[$eventName] as $_priority => $listener) {
            if ($priority === $_priority) {
                throw new DuplicatePriorityForEventListener(
                    $callableClass,
                    $eventName,
                    $this->listenerPriorities[$eventName][$priority],
                    $priority
                );
            }

            $callableExists = (false !== array_search($callableClass, $this->listenerPriorities[$eventName]));
            if (! $callable instanceof Closure && $callableExists) {
                throw new DuplicateListenerForEvent($callableClass, $eventName);
            }
        }

        $this->listenerPriorities[$eventName][$priority] = $callableClass;
        $this->dispatcher->addListener($eventName, $callable, $priority);
    }

    public function addHandler(string $message, callable $handler): void
    {
        $this->router->addHandler($message, $handler);
    }

    public function addPlugin(GamePlugin $plugin): void
    {
        $plugin->attach($this);
        $this->plugins[] = $plugin;
    }

    public function dispatchEvent(Event\GameEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->dispatcher->dispatch($event, $event->messageName());
            $this->dispatcher->dispatch($event, get_class($event));
        }
    }

    public function addObserver(EngineObserver $observer): void
    {
        $this->dispatcher->addObserver($observer);
    }

    public function dispatchCommand(GameCommand $command): void
    {
        $this->dispatcher->notifyScheduleCommand($command);

        $this->router->handle($command, new CommandRunner());
    }

    public function dispatchQuery(GameQuery $query): QueryResult
    {
        $this->router->handle($query, $runner = new QueryRunner());

        return $runner->getResult();
    }

    public function getGameResult(): GameResult
    {
        $result = new GameResult();
        $this->acceptGameVisitor($result);
    }

    public function addContextBuilder(ContextBuilder $builder): void
    {
        $this->contexts = $builder->create($this->contexts);
    }

    public function hasContext(string $name): bool
    {
        return $this->contexts->hasContext($name);
    }

    public function getContext(string $name): GameContext
    {
        return $this->contexts->getContext($name);
    }

    public function updateContext(string $name, GameContext $context): void
    {
        if (! $this->contexts->hasContext($name)) {
            throw new GameContextNotFound($name);
        }

        $this->contexts->updateContext($name, $context);
    }

    public function acceptGameVisitor(GameVisitor $visitor): void
    {
        foreach ($this->plugins as $plugin) {
            $visitor->visitPlugin($plugin);
        }

        $this->dispatcher->acceptGameVisitor($visitor);
        $this->router->acceptGameVisitor($visitor);
    }
}
