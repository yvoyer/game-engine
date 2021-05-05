<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping;

use LogicException;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\PlaceholderData;

final class MissingPlaceholderValue extends LogicException implements InvalidPlaceholderConstraint
{
    public function __construct(string $name, PlaceholderData $data)
    {
        parent::__construct(
            \sprintf(
                'The placeholder with name "%s", requires a value to be given in the data, "%s" given.',
                $name,
                $data->toJson()
            )
        );
    }
}
