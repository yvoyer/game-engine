<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use Star\GameEngine\Engine;
use Star\GameEngine\Extension\GamePlugin;
use Star\GameEngine\Extension\Interpretation\Effect\RunGameFunction;
use Star\GameEngine\Extension\Interpretation\Effect\RunGameFunctionHandler;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerCondition;
use Star\GameEngine\Extension\Interpretation\Trigger\TriggerConditionHandler;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Extension\StringLoaderExtension;
use Twig\Loader\FilesystemLoader;

final class InterpreterPlugin implements GamePlugin
{
    /**
     * @var GameExtension
     */
    private $container;

    public function __construct(GameExtension $container)
    {
        $this->container = $container;
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

        $constants = $this->container->getConstants();
        foreach ($constants as $constant) {
            $environment->addGlobal($constant->getName(), $constant());
        }

        $environment->addExtension($this->container);
        $environment->addExtension(new StringLoaderExtension());
        $environment->addExtension(new DebugExtension());

        $engine->addHandler(
            RunGameFunction::class,
            new RunGameFunctionHandler($environment)
        );
        $engine->addHandler(
            TriggerCondition::class,
            new TriggerConditionHandler($environment)
        );

        $triggers = $this->container->getTriggers();
        foreach ($triggers as $priority => $trigger) {
            $trigger->attachToEngine($engine, $priority);
        }
    }
}
