<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use PHPUnit\Framework\TestCase;

final class GameExtensionTest extends TestCase
{
    /**
     * @var GameExtension
     */
    private $extension;

    protected function setUp(): void
    {
        $this->extension = new GameExtension();
    }

    public function test_it_should_throw_exception_when_function_is_not_callable(): void
    {
        $this->extension->addFunction(new class implements GameFunction {
            public function getName(): string
            {
                return 'hello';
            }
        });

        $this->expectException(NotCallableFunction::class);
        $this->expectExceptionMessage(
            'The function "hello" is not callable. You need to implement the __invoke() method'
        );
        $this->extension->getFunctions();
    }

    public function test_it_should_throw_exception_when_function_is_already_defined(): void
    {
        $function = new CallableFunction(
            'hello',
            function (): void {
            }
        );
        $this->extension->addFunction($function);

        $this->expectException(DuplicateFunctionDefinition::class);
        $this->expectExceptionMessage('Function "hello" is already defined.');
        $this->extension->addFunction($function);
    }
}
