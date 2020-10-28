<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use RuntimeException;
use function sprintf;

final class HandlerNotFound extends RuntimeException
{
    public function __construct(string $command)
    {
        parent::__construct(
            sprintf('No command handler was found for command "%s".', $command)
        );
    }
}
