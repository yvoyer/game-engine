<?php declare(strict_types=1);

namespace Star\GameEngine\Runner;

use RuntimeException;
use Star\GameEngine\Messaging\GameMessage;
use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\Queries\QueryResult;
use Webmozart\Assert\Assert;

final class QueryRunner implements MessageRunner
{
    /**
     * @var QueryResult|null
     */
    private $result;

    public function run(callable $handler, GameMessage $message): void
    {
        Assert::isInstanceOf($message, GameQuery::class);
        $result = $handler($message);

        Assert::isInstanceOf($result, QueryResult::class);
        $this->result = $result;
    }

    public function getResult(): QueryResult
    {
        if (! $this->result instanceof QueryResult) {
            throw new RuntimeException('Query was not run.');
        }

        return $this->result;
    }
}
