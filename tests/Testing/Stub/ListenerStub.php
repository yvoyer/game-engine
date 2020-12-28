<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Stub;

final class ListenerStub
{
    public function __invoke(): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
