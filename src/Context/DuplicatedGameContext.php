<?php declare(strict_types=1);

namespace Star\GameEngine\Context;

final class DuplicatedGameContext extends \LogicException
{
    public function __construct(string $name)
    {
        parent::__construct(
            \sprintf('The game context "%s" is already set.', $name)
        );
    }
}
