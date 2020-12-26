<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use RuntimeException;
use function implode;
use function sprintf;
use function strripos;
use function substr;

final class DuplicatePriorityForEventListener extends RuntimeException
{
    public function __construct(string $addedListener, string $event, string $existingListener, int $priority)
    {
        parent::__construct(
            sprintf(
                'The listeners "%s" on event "%s" are registered with duplicated priority "%s".',
                implode(', ', [$this->getShortClass($addedListener), $this->getShortClass($existingListener)]),
                $this->getShortClass($event),
                $priority
            )
        );
    }

    private function getShortClass(string $long): string
    {
        $firstCharPosition = strripos($long, '\\');
        if (false === $firstCharPosition) {
            return $long;
        }

        return substr($long, $firstCharPosition + 1);
    }
}
