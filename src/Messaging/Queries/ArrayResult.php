<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

use Webmozart\Assert\Assert;

final class ArrayResult implements QueryResult
{
    /**
     * @var mixed[]
     */
    private $result;

    /**
     * @param mixed[] $result
     */
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

    /**
     * @return mixed[]
     */
    public function toArray(): array
    {
        return $this->result;
    }

    public function toObject()
    {
        throw NotSupportedResultConversion::toObjectConversionNotAllowed($this);
    }

    /**
     * @param class-string $class
     * @param mixed[] $result
     * @return QueryResult
     */
    public static function allInstanceOf(string $class, array $result): QueryResult
    {
        Assert::allIsInstanceOf(
            $result,
            $class,
            'Expected a collection of instances of "%2$s". Got: "%s".'
        );

        return new self($result);
    }
}
