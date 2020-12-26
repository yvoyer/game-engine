<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging;

final class PriorityLevel
{
    /**
     * @var int
     */
    private $level;

    private function __construct(int $level)
    {
        $this->level = $level;
    }

    public function toInt(): int
    {
        return $this->level;
    }

    /**
     * Last listeners to be called
     *
     * @return PriorityLevel
     */
    public static function verySlow(): self
    {
        return new self(-2);
    }

    public static function slow(): self
    {
        return new self(-1);
    }

    public static function normal(): self
    {
        return new self(0);
    }

    public static function fast(): self
    {
        return new self(1);
    }

    /**
     * First listeners triggered
     *
     * @return PriorityLevel
     */
    public static function veryFast(): self
    {
        return new self(2);
    }
}
