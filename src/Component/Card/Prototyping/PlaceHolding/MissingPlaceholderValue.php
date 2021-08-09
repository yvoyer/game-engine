<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use LogicException;

final class MissingPlaceholderValue extends LogicException implements InvalidPlaceholderConstraint
{
    public function __construct(string $name, string $data)
    {
        parent::__construct(
            \sprintf(
                'The placeholder with name "%s", requires a value to be given in the data, "%s" given.',
                $name,
                $data
            )
        );
    }
}
