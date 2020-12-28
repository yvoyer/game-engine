<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use Star\GameEngine\Extension\Interpretation\Trigger\GameTrigger;
use Twig\ExpressionParser;
use Twig\Extension\ExtensionInterface;
use Twig\Node\Expression\Binary\EqualBinary;
use Twig\NodeVisitor\NodeVisitorInterface;
use Twig\TokenParser\TokenParserInterface;
use Twig\TwigFilter;
use Twig\TwigFunction;
use Twig\TwigTest;
use function array_key_exists;
use function array_map;

final class GameExtension implements ExtensionInterface
{
    /**
     * @var callable[]|GameFunction[]
     */
    private $functions = [];

    /**
     * @var GameTrigger[]
     */
    private $triggers = [];

    /**
     * @var GameConstant[]
     */
    private $constants = [];

    public function addFunction(GameFunction $function): void
    {
        $name = $function->getName();
        if (array_key_exists($name, $this->functions)) {
            throw new DuplicateFunctionDefinition($name);
        }

        $this->functions[$name] = $function;
    }

    public function addTrigger(GameTrigger $trigger): void
    {
        $this->triggers[] = $trigger;
    }

    public function addConstant(GameConstant $constant): void
    {
        $this->constants[] = $constant;
    }

    /**
     * @return GameTrigger[]
     */
    public function getTriggers(): array
    {
        return $this->triggers;
    }

    /**
     * @return GameConstant[]
     */
    public function getConstants(): array
    {
        return $this->constants;
    }

    /**
     * @return TokenParserInterface[]
     */
    public function getTokenParsers(): array
    {
        return [];
    }

    /**
     * @return NodeVisitorInterface[]
     */
    public function getNodeVisitors(): array
    {
        return [];
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): array
    {
        return [];
    }

    /**
     * @return TwigTest[]
     */
    public function getTests(): array
    {
        return [];
    }

    /**
     * @return TwigFunction[]
     */
    public function getFunctions(): array
    {
        return array_map(
            function (GameFunction $function): TwigFunction {
                if (! is_callable($function)) {
                    throw new NotCallableFunction($function);
                }

                return new TwigFunction($function->getName(), $function);
            },
            $this->functions
        );
    }

    /**
     * @return array[]
     */
    public function getOperators(): array
    {
        return [
            [],
            [
                '=' => [
                    'precedence' => 20,
                    'class' => EqualBinary::class,
                    'associativity' => ExpressionParser::OPERATOR_LEFT,
                ],
            ],
        ];
    }
}
