<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

final class CallableFunction implements GameFunction
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var callable
     */
    private $callable;

    public function __construct(string $name, callable $callable)
    {
        $this->name = $name;
        $this->callable = $callable;
    }

    /**
     * @param mixed ...$arguments
     * @return mixed
     */
    public function __invoke(...$arguments)
    {
        $callable = $this->callable;

        return $callable(...$arguments);
    }

    public function getName(): string
    {
        return $this->name;
    }
}
