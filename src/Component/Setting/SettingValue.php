<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting;

interface SettingValue
{
    public function toInt(): int;

    public function toString(): string;

    public function toFloat(): float;

    public function toBool(): bool;

    public static function fromMixed($value): SettingValue;
}
