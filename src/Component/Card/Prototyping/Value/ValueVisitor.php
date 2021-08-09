<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Value;

interface ValueVisitor
{
    public function visitBooleanValue(bool $value): void;

    public function visitStringValue(string $value): void;

    public function visitIntegerValue(int $value): void;

    public function visitFloatValue(): void;

    public function enterChoiceValue(): void;

    public function exitChoiceValue(): void;
}
