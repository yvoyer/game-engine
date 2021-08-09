<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Star\GameEngine\Component\Card\CardVisitor;
use Star\GameEngine\NotAllowedMethodCall;
use function sprintf;

final class IntegerValue implements VariableValue
{
    /**
     * @var int
     */
    private $value;

    private function __construct(int $value)
    {
        $this->value = $value;
    }

    public function acceptCardVisitor(string $name, CardVisitor $visitor): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function acceptValueVisitor(ValueVisitor $visitor): void
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function isList(): bool
    {
        return false;
    }

    public function toList(): array
    {
        throw new NotAllowedMethodCall(__METHOD__, 'variable is integer');
    }

    public function toString(): string
    {
        return (string) $this->value;
    }

    public function toTypedString(): string
    {
        return sprintf('integer(%s)', $this->value);
    }

    public static function fromInt(int $value): self
    {
        return new self($value);
    }
}
