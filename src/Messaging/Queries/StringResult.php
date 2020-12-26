<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

final class StringResult implements QueryResult
{
    /**
     * @var string
     */
    private $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function toBool(): bool
    {
        throw NotSupportedResultConversion::toBoolConversionNotAllowed($this);
    }

    public function toString(): string
    {
        return $this->value;
    }

    public function toInt(): int
    {
        throw NotSupportedResultConversion::toIntConversionNotAllowed($this);
    }

    public function toFloat(): float
    {
        throw NotSupportedResultConversion::toFloatConversionNotAllowed($this);
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        throw NotSupportedResultConversion::toArrayConversionNotAllowed($this);
    }

    /**
     * @return object
     */
    public function toObject()
    {
        throw NotSupportedResultConversion::toObjectConversionNotAllowed($this);
    }

    public static function fromString(string $value): QueryResult
    {
        return new self($value);
    }
}
