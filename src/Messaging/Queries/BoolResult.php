<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

final class BoolResult implements QueryResult
{
    /**
     * @var bool
     */
    private $value;

    public function __construct(bool $value)
    {
        $this->value = $value;
    }

    public function toBool(): bool
    {
        return $this->value;
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
        throw NotSupportedResultConversion::toArrayConversionNotAllowed($this);
    }

    public function toObject()
    {
        throw NotSupportedResultConversion::toObjectConversionNotAllowed($this);
    }

    public static function asTrue(): QueryResult
    {
        return new self(true);
    }

    public static function asFalse(): QueryResult
    {
        return new self(false);
    }
}
