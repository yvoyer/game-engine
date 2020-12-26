<?php declare(strict_types=1);

namespace Star\GameEngine\Extension;

use Star\GameEngine\Engine;

interface GamePlugin
{
    public function attach(Engine $engine): void;
}
