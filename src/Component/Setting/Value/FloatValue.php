<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use Star\GameEngine\Component\Setting\SettingValue;

final class FloatValue implements SettingValue
{
    /**
     * @var float
     */
    private $value;

    private function __construct(float $value)
    {
        $this->value = $value;
    }

    public function toInt(): int
    {
        throw new NotSupportedTypeConversion($this->value, 'int');
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function toFloat(): float
    {
        return $this->value;
    }

    public function toBool(): bool
    {
        throw new NotSupportedTypeConversion($this->value, 'bool');
    }

    public static function fromMixed($value): SettingValue
    {
        return TypeGuesser::fromMixed($value);
    }

    public static function fromFloat(float $value): SettingValue
    {
        return new self($value);
    }
}
