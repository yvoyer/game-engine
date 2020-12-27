<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Trigger;

final class ConditionParser implements TriggerCondition
{
    /**
     * @var string
     */
    private $condition;

    private function __construct(string $condition)
    {
        $this->condition = $condition;
    }

    public static function fromString(string $condition): self
    {
        return new self($condition);
    }
}
