<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Stub;

final class NullEngine implements Engine
{
    public function addContextBuilder(ContextBuilder $builder): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function addListener(string $eventName, callable $callable, int $priority): void
    {
    }

    public function addHandler(string $message, callable $handler): void
    {
    }

    public function addPlugin(GamePlugin $plugin): void
    {
    }

    public function dispatchEvent(GameEvent ...$events): void
    {
        throw new \RuntimeException('The game engine must be set in order to dispatch the events.');
    }

    public function dispatchCommand(GameCommand $command): void
    {
        throw new \RuntimeException('The game engine must be set in order to dispatch the commands.');
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
