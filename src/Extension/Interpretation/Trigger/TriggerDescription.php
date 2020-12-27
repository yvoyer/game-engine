<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

final class TriggerDescription
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }
}
