<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping;

use ArrayAccess;
use Countable;
use Star\GameEngine\Component\Card\CardVisitor;
use function array_key_exists;
use function sprintf;

final class MapOfVariables implements Countable, ArrayAccess
{
    /**
     * @var CardVariable[]
     */
    private $map = [];

    public function __construct(CardVariable ...$variables)
    {
        \array_map(
            function (CardVariable $variable): void {
                $this->addVariable($variable->getName(), $variable);
            },
            $variables
        );
    }

    private function addVariable(string $name, CardVariable $variable): void
    {
        $this->map[$name] = $variable;
    }

    public function acceptCardVisitor(CardVisitor $visitor): void
    {
        foreach ($this->map as $variable) {
            $variable->acceptCardVisitor($visitor);
        }
    }

    public function count(): int
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function offsetExists($offset)
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function offsetGet($offset): CardVariable
    {
        if (! array_key_exists($offset, $this->map)) {
            throw new UndefinedVariable(
                sprintf('Variable "%s" is not defined.', $offset)
            );
        }

        return $this->map[$offset];
    }

    public function offsetSet($offset, $value)
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }

    public function offsetUnset($offset)
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
