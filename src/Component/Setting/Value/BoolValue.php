<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use Star\GameEngine\Component\Setting\SettingValue;

final class BoolValue implements SettingValue
{
    /**
     * @var bool
     */
    private $value;

    private function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function toInt(): int
    {
        return (int) $this->value;
    }

    public function toString(): string
    {
        return ($this->value) ? '1': '0';
    }

    public function toFloat(): float
    {
        throw new NotSupportedTypeConversion($this->value, 'float');
    }

    public function toBool(): bool
    {
        return $this->value;
    }

    public static function fromMixed($value): SettingValue
    {
        return TypeGuesser::fromMixed($value);
    }

    public static function fromBool(bool $value): SettingValue
    {
        return new self($value);
    }
}
