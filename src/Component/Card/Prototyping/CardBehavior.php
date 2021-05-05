<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping;

/**
 * A behavior is a routine that may be executed during the game.
 *
 * Example of behavior in card games:
 *    - Abilities of unit
 *    - Effect of event triggered in a phase
 */
interface CardBehavior
{
    public function getName(): string;
}
