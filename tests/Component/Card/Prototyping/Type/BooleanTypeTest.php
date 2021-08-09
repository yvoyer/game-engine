<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class BooleanTypeTest extends TestCase
{
    public function test_it_should_build_card_with_boolean_variable(): void
    {
        $card = CardBuilder::create()
            ->withBooleanVariable('key', true)
            ->buildCard();

        self::assertSame('boolean(true)', $card->getVariableValue('key')->toTypedString());
    }
}
