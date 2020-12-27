<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use Star\GameEngine\Engine;
use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\Extension\Interpretation\Command\RunGameFunction;
use Star\GameEngine\Extension\Interpretation\Command\RunGameFunctionHandler;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

final class InterpreterPlugin implements GamePlugin
{
    /**
     * @var GameContainer
     */
    private $container;

    /**
     * @var bool
     */
    private $throwTwigException;

    public function __construct(GameContainer $container, bool $throwException = true)
    {
        $this->container = $container;
        $this->throwTwigException = $throwException;
    }

    public function attach(Engine $engine): void
    {
        $environment = new Environment(
            new FilesystemLoader(
                [
                    __DIR__ . '/Resources/',
                ]
            ),
            [
                'debug' => true,
                'strict_variables' => true,
            ]
        );

        $environment->addExtension($this->container->createExtension());
        $engine->addHandler(
            RunGameFunction::class,
            new RunGameFunctionHandler($environment, $this->throwTwigException)
        );
    }
}
