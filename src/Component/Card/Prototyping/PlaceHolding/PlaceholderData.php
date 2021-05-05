<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

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

    public function getStringValue(string $key): string
    {
        return $this->data[$key];
    }

    public function hasKey(string $key): bool
    {
        return \array_key_exists($key, $this->data);
    }

    public function toJson(): string
    {
        return \json_encode($this->data);
    }

    public static function fromArray(array $data): self
    {
        return new self($data);
    }
}
