<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

use Star\GameEngine\Messaging\Queries\QueryResult;
use Twig\Environment;
use function sprintf;

final class TriggerConditionHandler
{
    /**
     * @var Environment
     */
    private $env;

    public function __construct(Environment $env)
    {
        $this->env = $env;
    }

    public function __invoke(TriggerCondition $query): QueryResult
    {
        $condition = $query->toString();

        $return = $this->env->render(
            'evaluate.twig',
            [
                'context' => sprintf('{{ %s ? "true" : "false" }}', $condition),
            ]
        );

        $result = null;
        if ($return === 'true') {
            $result = true;
        } elseif ($return === 'false') {
            $result = false;
        }

        return $query->createResult($result);
    }
}
