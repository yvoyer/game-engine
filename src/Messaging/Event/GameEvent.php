<?php declare(strict_types=1);

namespace Star\GameEngine\Messaging\Event;

use Doctrine\Inflector\InflectorFactory;
use Star\Component\DomainEvent\DomainEvent;
use Symfony\Contracts\EventDispatcher\Event;
use function get_class;
use function strlen;
use function strrpos;
use function substr;

abstract class GameEvent extends Event implements DomainEvent
{
    abstract public function toString(): string;

    final public function messageName(): string
    {
        $class = get_class($this);
        $short = substr($class, (int) strrpos($class, '\\') + 1, strlen($class));

        $inflector = InflectorFactory::create()->build();

        return $inflector->urlize($inflector->tableize($short));
    }

    /**
     * @return mixed[]
     */
    abstract public function payload(): array;
}
