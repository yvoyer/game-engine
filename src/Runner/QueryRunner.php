<?php declare(strict_types=1);

namespace Star\GameEngine\Runner;

use RuntimeException;
use Star\GameEngine\Messaging\GameMessage;
use Star\GameEngine\Messaging\GameQuery;
use Star\GameEngine\Messaging\Queries\QueryResult;
use Webmozart\Assert\Assert;
use function get_class;
use function sprintf;

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

        Assert::isInstanceOf(
            $result,
            QueryResult::class,
            sprintf(
                'The query handler for the query "%s" must return the QueryResult.',
                get_class($message)
            )
        );
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
