<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\Queries\BoolResult;
use Star\GameEngine\Messaging\Queries\QueryResult;

final class TriggerCondition implements GameQuery
{
    /**
     * @var string
     */
    private $condition;

    public function __construct(string $condition)
    {
        $this->condition = $condition;
    }

    public function toString(): string
    {
        return $this->condition;
    }

    public function createResult($result): QueryResult
    {
        return new BoolResult($result);
    }
}
