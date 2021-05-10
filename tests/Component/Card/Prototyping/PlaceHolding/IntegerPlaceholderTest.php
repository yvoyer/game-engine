<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class IntegerPlaceholderTest extends TestCase
{
    public function test_it_should_build_card_with_integer_place_holder(): void
    {
        $card = CardBuilder::create()
            ->withIntegerPlaceholder('key')
            ->buildCard(['key' => 123]);

        self::assertSame('integer(123)', $card->getVariableValue('key')->toTypedString());
    }
}
