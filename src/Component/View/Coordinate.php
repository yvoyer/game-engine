<?php declare(strict_types=1);

namespace Star\GameEngine\Component\View;

use Assert\Assertion;
use function explode;
use function sprintf;

final class Coordinate
{
    /**
     * @var string
     */
    private $x;

    /**
     * @var string
     */
    private $y;

    private function __construct(string $x, string $y)
    {
        Assertion::notEmpty($x, 'X-axis "%s" is empty, but non empty value was expected.');
        Assertion::notEmpty($y, 'Y-axis "%s" is empty, but non empty value was expected.');
        $this->x = $x;
        $this->y = $y;
    }

    public function getX(): string
    {
        return $this->x;
    }

    public function getY(): string
    {
        return $this->y;
    }

    public function toString(): string
    {
        return sprintf('%s,%s', $this->x, $this->y);
    }

    public static function fromStrings(string $x, string $y): self
    {
        return new self($x, $y);
    }

    public static function fromString(string $coordinate): self
    {
        $parts = explode(',', $coordinate);
        Assertion::count(
            $parts,
            2,
            sprintf('Coordinate "%s" is not a valid format, expected "x,y".', $coordinate)
        );

        return self::fromStrings($parts[0], $parts[1]);
    }
}
