<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

use RuntimeException;
use function sprintf;

final class HandlerNotFound extends RuntimeException
{
    public function __construct(string $message)
    {
        parent::__construct(
            sprintf('No message handler was found for message "%s".', $message)
        );
    }
}
