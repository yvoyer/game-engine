<?php declare(strict_types=1);

namespace Star\GameEngine\Result;

interface ResultBuilder
{
    public function createResult(): GameResult;
}
