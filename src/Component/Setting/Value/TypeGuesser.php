<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Value;

use InvalidArgumentException;
use Star\GameEngine\Component\Setting\SettingValue;
use function gettype;
use function is_bool;
use function is_int;
use function is_numeric;
use function is_string;
use function sprintf;

final class TypeGuesser
{
    /**
     * @param mixed $value
     * @return SettingValue
     */
    public static function fromMixed($value): SettingValue
    {
        if (is_bool($value)) {
            return BoolValue::fromBool($value);
        }

        if (is_numeric($value)) {
            if (is_int($value) || (int) $value == $value) {
                return IntegerValue::fromInt((int) $value);
            }

            return FloatValue::fromFloat((float) $value);
        }

        if (! is_string($value)) {
            throw new InvalidArgumentException(
                sprintf('Value type "%s" cannot be guessed.', gettype($value))
            );
        }

        return StringValue::fromString($value);
    }
}
