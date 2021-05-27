<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Star\GameEngine\Component\Card\CardVisitor;
use Star\GameEngine\NotAllowedMethodCall;
use function sprintf;

final class StringValue implements VariableValue
{
    /**
     * @var string
     */
    private $value;

    private function __construct(string $value)
    {
        $this->value = $value;
    }

    public function acceptCardVisitor(string $name, CardVisitor $visitor): void
    {
        $visitor->visitTextVariable($name, $this);
    }

    public function acceptValueVisitor(ValueVisitor $visitor): void
    {
        $visitor->visitStringValue($this->value);
    }

    public function isList(): bool
    {
        return false;
    }

    public function toList(): array
    {
        throw new NotAllowedMethodCall(__METHOD__, 'variable is string');
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function toTypedString(): string
    {
        return sprintf('string(%s)', $this->value);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }
}
