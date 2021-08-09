<?php declare(strict_types=1);

namespace Star\GameEngine;

use RuntimeException;

final class NotAllowedMethodCall extends RuntimeException
{
    public function __construct(string $method, string $reason)
    {
        parent::__construct(
            \sprintf(
                'Not allowed to call method "%s" when %s.',
                $method,
                $reason
            )
        );
    }
}
