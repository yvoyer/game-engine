<?php declare(strict_types=1);

namespace Star\GameEngine\Extension\Interpretation;

interface GameConstant
{
    public function getName(): string;

    /**
     * @return mixed
     */
    public function __invoke();
}
