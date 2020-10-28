<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

use LogicException;
use function sprintf;

final class GameContextNotFound extends LogicException
{
    public function __construct(string $name)
    {
        parent::__construct(
            sprintf('The game context "%s" could not be found.', $name)
        );
    }
}
