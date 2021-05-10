<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class BooleanPlaceholderTest extends TestCase
{
    public function test_it_should_build_card_with_boolean_place_holder(): void
    {
        $card = CardBuilder::create()
            ->withBooleanPlaceholder('key')
            ->buildCard(['key' => false]);

        self::assertSame('boolean(false)', $card->getVariableValue('key')->toTypedString());
    }
}
