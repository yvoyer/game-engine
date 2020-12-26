<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

final class NotSupportedResultConversion extends \RuntimeException
{
    public function __construct(QueryResult $result, string $type)
    {
        parent::__construct(
            \sprintf(
                'Conversion of result from "%s" to "%s" is not supported.',
                \get_class($result),
                $type
            )
        );
    }

    public static function toStringConversionNotAllowed(QueryResult $result): self
    {
        return new self($result, 'string');
    }

    public static function toIntConversionNotAllowed(QueryResult $result): self
    {
        return new self($result, 'int');
    }

    public static function toBoolConversionNotAllowed(QueryResult $result): self
    {
        return new self($result, 'bool');
    }

    public static function toFloatConversionNotAllowed(QueryResult $result): self
    {
        return new self($result, 'float');
    }

    public static function toArrayConversionNotAllowed(QueryResult $result): self
    {
        return new self($result, 'array');
    }

    public static function toObjectConversionNotAllowed(QueryResult $result): self
    {
        return new self($result, 'object');
    }
}
