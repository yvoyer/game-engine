<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

final class IntResult implements QueryResult
{
    /**
     * @var int
     */
    private $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function toBool(): bool
    {
        throw NotSupportedResultConversion::toBoolConversionNotAllowed($this);
    }

    public function toString(): string
    {
        return (string) $this->toInt();
    }

    public function toInt(): int
    {
        return $this->value;
    }

    public function toFloat(): float
    {
        return (float) $this->toInt();
    }

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        throw NotSupportedResultConversion::toArrayConversionNotAllowed($this);
    }

    public function toObject()
    {
        throw NotSupportedResultConversion::toObjectConversionNotAllowed($this);
    }

    public static function fromInt(int $value): QueryResult
    {
        return new self($value);
    }
}
