<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Command;

use Twig\Environment;
use Twig\Error\RuntimeError;

final class RunGameFunctionHandler
{
    /**
     * @var Environment
     */
    private $env;

    /**
     * @var bool
     */
    private $throwException;

    public function __construct(Environment $env, bool $throwException)
    {
        $this->env = $env;
        $this->throwException = $throwException;
    }

    public function __invoke(RunGameFunction $command): void
    {
        try {
            $return = $this->env->render(
                'function.twig',
                [
                    'name' => $command->getFunction(),
                    'arguments' => $command->getArguments(),
                ]
            );
        } catch (RuntimeError $exception) {
            if ($this->throwException) {
                throw $exception->getPrevious();
            }
        }

        \var_dump($return);

        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
