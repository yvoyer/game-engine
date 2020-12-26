<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Star\GameEngine\Messaging\Queries\QueryResult;

interface GameQuery extends GameMessage
{
    /**
     * @param mixed $result
     * @return QueryResult
     */
    public function createResult($result): QueryResult;
}
