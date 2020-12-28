<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

use InvalidArgumentException;

final class DuplicateFunctionDefinition extends InvalidArgumentException
{
    public function __construct(string $name)
    {
        parent::__construct(sprintf('Function "%s" is already defined.', $name));
    }
}
