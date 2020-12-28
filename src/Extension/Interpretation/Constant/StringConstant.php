<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation\Constant;

use Star\GameEngine\Extension\Interpretation\GameConstant;

final class StringConstant implements GameConstant
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $value;

    public function __construct(string $name, string $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function __invoke(): string
    {
        return $this->value;
    }
}
