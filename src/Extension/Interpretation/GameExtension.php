<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use function is_callable;

final class GameExtension extends AbstractExtension
{
    /**
     * @var GameContainer
     */
    private $container;

    public function __construct(GameContainer $container)
    {
        $this->container = $container;
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'game_core_function',
                function (string $functionName, array $arguments) {
                    $function = $this->container->findFunction($functionName);
                    if (! is_callable($function)) {
                        throw new NotCallableFunction($function);
                    }

                    return $function(...$arguments);
                }
            ),
        ];
    }
}
