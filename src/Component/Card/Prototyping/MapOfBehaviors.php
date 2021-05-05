<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping;

use Countable;
use Star\GameEngine\Component\Card\CardVisitor;

final class MapOfBehaviors implements Countable
{
    /**
     * @var CardBehavior[]
     */
    private $map = [];

    public function __construct(CardBehavior ...$behaviors)
    {
        \array_map(
            function (string $name, CardBehavior $behavior): void {
                $this->addBehavior($behavior);
            },
            $behaviors
        );
    }

    public function acceptCardVisitor(CardVisitor $visitor): void
    {
        foreach ($this->map as $behavior) {
            $visitor->visitBehavior($behavior);
        }
    }

    private function addBehavior(CardBehavior $behavior): void
    {
        $this->map[$behavior->getName()] = $behavior;
    }

    public function count(): int
    {
        throw new \RuntimeException(__METHOD__ . ' not implemented yet.');
    }
}
