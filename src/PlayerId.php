<?php declare(strict_types=1);

namespace Star\GameEngine;

use Star\Component\Identity\StringIdentity;

final class PlayerId extends StringIdentity
{
    public static function fromString(string $value): PlayerId
    {
        return new static($value);
    }
}
