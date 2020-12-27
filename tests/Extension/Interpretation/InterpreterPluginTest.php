<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Extension\Interpretation\Command\RunGameFunction;
use Star\GameEngine\GameEngine;

final class InterpreterPluginTest extends TestCase
{
    public function test_it_should_throw_exception_when_function_is_not_callable(): void
    {
        $container = new GameContainer();
        $container->addFunction(new class implements GameFunction {
            public function getName(): string
            {
                return 'hello';
            }
        });

        $engine = new GameEngine();
        $engine->addPlugin(new InterpreterPlugin($container, false));

        $this->expectException(NotCallableFunction::class);
        $this->expectExceptionMessage('dada');
        $engine->dispatchCommand(new RunGameFunction('hello'));
    }

    public function test_it_should_interpret_functions(): void
    {
        $container = new GameContainer();
#        $container->addFunction(new class implements GameFunction {
 #           public function getName(): string
  #          {
   #             return 'hello';
    #        }
     #   });

        $engine = new GameEngine();
        $engine->addPlugin(new InterpreterPlugin($container));
        $engine->dispatchCommand(new RunGameFunction('hello'));
    }

    public function test_it_should_interpret_functions_with_arguments(): void
    {
        $container = new GameContainer();
        $container->addFunction(new class implements GameFunction {
            public function getName(): string
            {
                return 'hello';
            }
        });

        $engine = new GameEngine();
        $engine->addPlugin(new InterpreterPlugin($container));
        $engine->dispatchCommand(new RunGameFunction('hello', ['name' => 'Joe']));
        $this->fail('todo');
    }
}
