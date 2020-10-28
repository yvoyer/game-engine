<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\GameEngine;

final class ListenerPriorityTreeTest extends TestCase
{
    public function test_it_should_dump_listeners_by_priority(): void
    {
        $engine = new GameEngine();
        $engine->addListener('event-1', new StubListenerOne(), 50);
        $engine->addListener('event-2', new StubListenerTwo(), 50);
        $engine->addListener('event-3', new StubListenerThree(), 50);
        $engine->acceptGameVisitor($dumper = new ListenerPriorityTree());

        $this->assertSame(
            [
                'event-1' => [
                    StubListenerOne::class,
                ],
                'event-2' => [
                    StubListenerTwo::class,
                ],
                'event-3' => [
                    StubListenerThree::class,
                ],
            ],
            $dumper->getListenerStructure()
        );
    }

    public function test_it_should_dump_listeners_of_same_event(): void
    {
        $engine = new GameEngine();
        $engine->addListener('event', new StubListenerOne(), 10);
        $engine->addListener('event', new StubListenerTwo(), 70);
        $engine->addListener('event', new StubListenerThree(), 80);
        $engine->acceptGameVisitor($dumper = new ListenerPriorityTree());

        $this->assertSame(
            [
                'event' => [
                    StubListenerThree::class,
                    StubListenerTwo::class,
                    StubListenerOne::class,
                ],
            ],
            $dumper->getListenerStructure()
        );
    }
}

final class StubListenerOne
{
    public function __invoke(): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }
}

final class StubListenerTwo
{
    public function __invoke(): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }
}

final class StubListenerThree
{
    public function __invoke(): void
    {
        throw new \RuntimeException('Method ' . __METHOD__ . ' not implemented yet.');
    }
}
