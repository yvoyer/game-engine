<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Token;

final class StringToken implements GameToken
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toString(): string
    {
        return $this->value;
    }

    public static function fromString(string $token): GameToken
    {
        return new self($token);
    }
}
