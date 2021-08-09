<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Star\GameEngine\Component\Card\CardVisitor;
use Star\GameEngine\NotAllowedMethodCall;
use function sprintf;

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

    public function acceptValueVisitor(ValueVisitor $visitor): void
    {
        $visitor->visitBooleanValue($this->value);
    }

    public function isList(): bool
    {
        return false;
    }

    public function toList(): array
    {
        throw new NotAllowedMethodCall(__METHOD__, 'variable is boolean');
    }

    public function toString(): string
    {
        return ($this->value) ? '1' : '0';
    }

    public function toTypedString(): string
    {
        return sprintf('boolean(%s)', ($this->value) ? 'true' : 'false');
    }

    public static function fromBoolean(bool $value): self
    {
        return new self($value);
    }

    public static function asTrue(): self
    {
        return self::fromBoolean(true);
    }

    public static function asFalse(): self
    {
        return self::fromBoolean(false);
    }
}
