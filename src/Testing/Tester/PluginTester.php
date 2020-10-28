<?php declare(strict_types=1);

namespace Star\GameEngine\Testing\Tester;

use PHPUnit\Framework\Assert;
use Star\GameEngine\Context\ContextBuilder;
use Star\GameEngine\Context\NoContext;
use Star\GameEngine\Engine;
use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\GameEngine;
use Star\GameEngine\Messaging\Event\GameEvent;
use Star\GameEngine\Messaging\GameCommand;
use Star\GameEngine\Messaging\MessageLookup;
use function array_map;
use function array_merge;
use function count;
use function get_class;
use function is_subclass_of;
use function sprintf;

final class PluginTester
{
    /**
     * @var Engine
     */
    private $engine;

    /**
     * @var bool[] Indexed by event name
     */
    private $dispatchedEvents = [];

    /**
     * @var bool[] Indexed by command name
     */
    private $dispatchedCommands = [];

    /**
     * @var bool[] Indexed by command name
     */
    private $notDispatchedCommands = [];

    /**
     * @var callable[][]
     */
    private $contextAssertions = [];

    private function __construct(ContextBuilder $builder, GamePlugin ...$plugins)
    {
        $this->engine = new GameEngine();
        $this->engine->addContextBuilder($builder);
        array_map(
            function (GamePlugin $plugin) {
                $this->engine->addPlugin($plugin);
            },
            $plugins
        );
    }

    public static function withPlugins(GamePlugin ...$plugins): self
    {
        return new self(new NoContext(), ...$plugins);
    }

    public static function withContext(ContextBuilder $builder, GamePlugin ...$plugins): self
    {
        return new self($builder, ...$plugins);
    }

    public function addListener(string $name, callable $callable, int $priority): void
    {
        $this->engine->addListener($name, $callable, $priority);
    }

    public function addCommandHandler(string $name, callable $callable): void
    {
        $this->engine->addHandler($name, $callable);
    }

    public function expectCommandToBeDispatched(string $class, bool $skipHandlerCheck = false): self
    {
        Assert::assertTrue(
            is_subclass_of($class, GameCommand::class),
            sprintf('Class "%s" was expected to be instance of GameCommand, but it is not.', $class)
        );
        if (! $skipHandlerCheck) {
            $this->engine->acceptGameVisitor($visitor = new MessageLookup());
            Assert::assertTrue(
                $visitor->isRegistered($class),
                sprintf('The engine must have a registered handler for command "%s".', $class)
            );
        }


        $this->dispatchedCommands[$class] = false;
        $this->engine->addHandler(
            $class,
            function (GameCommand $command) {
                $this->dispatchedCommands[get_class($command)] = true;
            }
        );

        return $this;
    }

    public function assertQueryIsRegistered(string $query): void {
        $this->engine->acceptGameVisitor($visitor = new MessageLookup());
        Assert::assertTrue($visitor->isRegistered($query));
    }

    public function expectCommandIsNotDispatched(string $class): self
    {
        Assert::assertTrue(
            is_subclass_of($class, GameCommand::class),
            sprintf('Class "%s" was expected to be instance of GameCommand, but it is not.', $class)
        );

        $this->notDispatchedCommands[$class] = true;
        $this->engine->addHandler(
            $class,
            function (GameCommand $command) {
                $this->notDispatchedCommands[get_class($command)] = false;
            }
        );

        return $this;
    }

    public function expectEventToBeDispatched(string $class): self
    {
        Assert::assertTrue(
            is_subclass_of($class, GameEvent::class),
            sprintf('Class "%s" was expected to be instance of GameEvent, but it is not.', $class)
        );
        $this->dispatchedEvents[$class] = false;
        $this->engine->addListener(
            $class,
            function () use ($class) {
                $this->dispatchedEvents[$class] = true;
            },
            10000
        );

        return $this;
    }

    public function expectContextIs(string $context, callable $expectation): self
    {
        $this->contextAssertions[$context][] = $expectation;

        return $this;
    }

    private function assertExpectations(): void
    {
        Assert::assertGreaterThan(
            0,
            count(
                array_merge(
                    $this->dispatchedCommands,
                    $this->dispatchedEvents,
                    $this->notDispatchedCommands,
                    $this->contextAssertions
                )
            ),
            'Must have at least one message expectation.'
        );
        $this->assertExpectedEventsAreDispatched();
        $this->assertExpectedCommandsAreDispatched();
        $this->assertExpectedCommandsAreNotDispatched();
        $this->assertExpectedContext();
    }

    public function whenCommandIssued(GameCommand $command, GameCommand ...$others): void
    {
        array_map(
            function (GameCommand $command) {
                $this->engine->dispatchCommand($command);
            },
            array_merge([$command], $others)
        );

        $this->assertExpectations();
    }

    public function whenEventDispatched(GameEvent $first, GameEvent ...$others): void
    {
        array_map(
            function (GameEvent $event) {
                $this->engine->dispatchEvent($event);
            },
            array_merge([$first], $others)
        );

        $this->assertExpectations();
    }

    public function getContext(string $name, string $class): GameContext
    {
        $this->expectContextExists($name);
        $this->expectContextInstanceOf($name, $class);

        return $this->engine->getContext($name);
    }

    private function assertExpectedEventsAreDispatched(): void
    {
        foreach ($this->dispatchedEvents as $event => $value) {
            Assert::assertTrue(
                $value,
                sprintf('Event "%s" was expected to be dispatched, but was not.', $event)
            );
        }
    }

    private function assertExpectedCommandsAreDispatched(): void
    {
        foreach ($this->dispatchedCommands as $command => $value) {
            Assert::assertTrue(
                $value,
                sprintf('Command "%s" was expected to be dispatched, but was not.', $command)
            );
        }
    }

    private function assertExpectedCommandsAreNotDispatched(): void
    {
        foreach ($this->notDispatchedCommands as $command => $value) {
            Assert::assertTrue(
                $value,
                sprintf('Command "%s" was not expected to be dispatched, but was.', $command)
            );
        }
    }

    private function assertExpectedContext(): void
    {
        foreach ($this->contextAssertions as $contextName => $callables) {
            $context = $this->engine->getContext($contextName);

            foreach ($callables as $callable) {
                $callable($context);
            }
        }
    }

    private function expectContextInstanceOf(string $contextName, string $class): self {
        $this->expectContextExists($contextName);
        Assert::assertInstanceOf(
            $class,
            $this->engine->getContext($contextName)
        );

        return $this;
    }

    private function expectContextExists(string $contextName): self
    {
        Assert::assertTrue(
            $this->engine->hasContext($contextName),
            'The context with ' . $contextName . ' name was expected to be defined, but is not.'
        );

        return $this;
    }
}
