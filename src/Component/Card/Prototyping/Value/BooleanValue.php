<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Star\GameEngine\Component\Card\CardVisitor;

final class BooleanValue implements VariableValue
{
    /**
     * @var bool
     */
    private $value;

    private function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function acceptCardVisitor(string $name, CardVisitor $visitor): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function toTypedString(): string
    {
        return \sprintf('boolean(%s)', ($this->value) ? 'true' : 'false');
    }

    public function toString(): string
    {
        return ($this->value) ? '1' : '0';
    }

    public static function fromBoolean(bool $value): self
    {
        return new self($value);
    }
}
