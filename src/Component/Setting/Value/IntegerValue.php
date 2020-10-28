<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use Star\GameEngine\Component\Setting\SettingValue;

final class IntegerValue implements SettingValue
{
    /**
     * @var int
     */
    private $value;

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function toFloat(): float
    {
        return (float) $this->value;
    }

    public function toBool(): bool
    {
        throw new NotSupportedTypeConversion($this->value, 'bool');
    }

    public static function fromMixed($value): SettingValue
    {
        return TypeGuesser::fromMixed($value);
    }

    public static function fromInt(int $value): SettingValue
    {
        return new self($value);
    }
}
