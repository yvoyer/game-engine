<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Stub;

final class BufferedEngine implements Engine
{
    /**
     * @var GameEvent[]
     */
    private $events = [];

    public function getDispatchedEvents(): array
    {
        return $this->events;
    }

    public function addContextBuilder(ContextBuilder $builder): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function addListener(string $eventName, callable $callable, int $priority): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    public function addHandler(string $message, callable $handler): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    public function addPlugin(GamePlugin $plugin): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    public function dispatchEvent(GameEvent ...$events): void
    {
        \array_map(
            function (GameEvent $event): void {
                $this->events[] = $event;
            },
            $events
        );
    }

    public function dispatchCommand(GameCommand $command): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    public function addObserver(EngineObserver $observer): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }

    public function dispatchQuery(GameQuery $query): QueryResult
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function getGameResult(): GameResult
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
