<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

final class TriggerFrequency
{
    /**
     * @var int
     */
    private $value;

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public static function fromInt(int $int): self
    {
        return new self($int);
    }
}
