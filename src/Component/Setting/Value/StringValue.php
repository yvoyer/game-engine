<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use Star\GameEngine\Component\Setting\SettingValue;

final class StringValue implements SettingValue
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toInt(): int
    {
        throw new NotSupportedTypeConversion($this->value, 'int');
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function toFloat(): float
    {
        throw new NotSupportedTypeConversion($this->value, 'float');
    }

    public function toBool(): bool
    {
        throw new NotSupportedTypeConversion($this->value, 'bool');
    }

    public static function fromString(string $string): SettingValue
    {
        return new self($string);
    }
}
