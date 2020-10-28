<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use Webmozart\Assert\Assert;

final class ArrayResult implements QueryResult
{
    /**
     * @var mixed[]
     */
    private $result = [];

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function toBool(): bool
    {
        throw NotSupportedResultConversion::toBoolConversionNotAllowed($this);
    }

    public function toString(): string
    {
        throw NotSupportedResultConversion::toStringConversionNotAllowed($this);
    }

    public function toInt(): int
    {
        throw NotSupportedResultConversion::toIntConversionNotAllowed($this);
    }

    public function toFloat(): float
    {
        throw NotSupportedResultConversion::toFloatConversionNotAllowed($this);
    }

    public function toArray(): array
    {
        return $this->result;
    }

    public function toObject()
    {
        throw NotSupportedResultConversion::toObjectConversionNotAllowed($this);
    }

    public static function allInstanceOf(string $class, array $result): self
    {
        Assert::allIsInstanceOf($result, $class);
        return new self($result);
    }
}
