<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use LogicException;
use PHPUnit\Framework\TestCase;
use Star\GameEngine\Engine;
use Star\GameEngine\Extension\Interpretation\Effect\RunGameFunction;
use Star\GameEngine\GameEngine;

final class InterpreterPluginTest extends TestCase
{
    public function test_it_should_throw_exception_when_function_is_not_defined(): void
    {
        $engine = new GameEngine();
        $engine->addPlugin(new InterpreterPlugin(new GameExtension()));

        $this->expectException(FunctionRuntimeError::class);
        $this->expectExceptionMessage('Unknown "hello" function. in source: "{{ hello() }}".');
        $engine->dispatchCommand(new RunGameFunction('hello()'));
    }

    public function test_it_should_throw_exception_when_non_twig_error(): void
    {
        $engine = new GameEngine();
        $extension = new GameExtension();
        $extension->addFunction(
            new CallableFunction(
                'test',
                function (): void {
                    throw new LogicException('error');
                }
            )
        );
        $engine->addPlugin(new InterpreterPlugin($extension));

        $this->expectException(FunctionRuntimeError::class);
        $this->expectExceptionMessage(
            'An exception has been thrown during the rendering of a template ("error"). in source: "{{ test() }}".'
        );
        $engine->dispatchCommand(new RunGameFunction('test()'));
    }
}
