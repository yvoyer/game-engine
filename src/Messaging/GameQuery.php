<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use Star\GameEngine\Queries\QueryResult;

interface GameQuery extends GameMessage
{
    public function createResult($result): QueryResult;
}
