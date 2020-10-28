<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Queries;

interface QueryResult
{
    /**
     * @return bool
     * @throws NotSupportedResultConversion
     */
    public function toBool(): bool;

    /**
     * @return string
     * @throws NotSupportedResultConversion
     */
    public function toString(): string;

    /**
     * @return int
     * @throws NotSupportedResultConversion
     */
    public function toInt(): int;

    /**
     * @return float
     * @throws NotSupportedResultConversion
     */
    public function toFloat(): float;

    /**
     * @return array
     * @throws NotSupportedResultConversion
     */
    public function toArray(): array;

    /**
     * @return object
     * @throws NotSupportedResultConversion
     */
    public function toObject();
}
