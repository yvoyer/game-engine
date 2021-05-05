<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

use Star\GameEngine\Component\Card\CardVisitor;
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

    public function toTypedString(): string
    {
        return sprintf('string(%s)', $this->value);
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public function acceptCardVisitor(string $name, CardVisitor $visitor): void
    {
        $visitor->visitTextVariable($name, $this);
    }
}
