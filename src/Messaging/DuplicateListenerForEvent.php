<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use RuntimeException;
use function sprintf;

final class DuplicateListenerForEvent extends RuntimeException
{
    public function __construct(string $listener, string $event)
    {
        parent::__construct(
            sprintf(
                'Listener "%s" was already registered for event "%s".',
                $listener,
                $event
            )
        );
    }
}
