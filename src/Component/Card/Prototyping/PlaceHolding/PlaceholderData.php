<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use Assert\Assertion;
use Star\GameEngine\Component\Card\Prototyping\Value\ArrayOfValues;
use function array_key_exists;
use function json_encode;

/**
 * @api
 */
final class PlaceholderData
{
    /**
     * @var array
     */
    private $data;

    private function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getIntegerValue(string $key): int
    {
        Assertion::integerish(
            $value = $this->getMixedValue($key),
            'Value "%s" for key "' . $key . '" is not castable to integer.'
        );

        return (int) $value;
    }

    public function getStringValue(string $key): string
    {
        return (string) $this->getMixedValue($key);
    }

    public function getBooleanValue(string $key): bool
    {
        Assertion::boolean($value = $this->getMixedValue($key));

        return $value;
    }

    public function getChoicesValue(string $key): ArrayOfValues
    {
        $value = (array) $this->getMixedValue($key);

        return ArrayOfValues::arrayOfUnknowns(...$value);
    }

    private function getMixedValue(string $key)
    {
        if (! $this->hasKey($key)) {
            throw new MissingPlaceholderValue($key, $this->toJson());
        }

        return $this->data[$key];
    }

    private function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    private function toJson(): string
    {
        return json_encode($this->data);
    }

    public static function fromArray(array $data): self
    {
        Assertion::allNotNull($data);

        return new self($data);
    }

    public static function noData(): self
    {
        return self::fromArray([]);
    }
}
