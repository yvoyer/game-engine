<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Effect;

use Star\GameEngine\Extension\Interpretation\FunctionRuntimeError;
use Twig\Environment;
use Twig\Error\Error;
use Twig\Source;
use function sprintf;

final class RunGameFunctionHandler
{
    /**
     * @var Environment
     */
    private $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function __invoke(RunGameFunction $command): void
    {
        $function = $command->getFunction();

        try {
            $this->env->render(
                'evaluate.twig',
                [
                    'context' => sprintf('{{ %s }}', $function),
                ]
            );
        } catch (Error $exception) {
            $code = $exception->getSourceContext();
            if ($code instanceof Source) {
                $code = $code->getCode();
            }

            throw new FunctionRuntimeError(
                sprintf('%s in source: "%s".', $exception->getRawMessage(), $code),
                0,
                $exception
            );
        }
    }
}
