<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class MixedChoicesPlaceholderTest extends TestCase
{
    public function test_it_should_build_card_with_option_of_strings_place_holder(): void
    {
        $card = CardBuilder::create()
            ->withChoicesPlaceholder('option', ['one', 'two', 'three'])
            ->buildCard(['option' => ['two']]);

        self::assertSame('choice(two)', $card->getVariableValue('option')->toTypedString());
    }

    public function test_it_should_build_card_with_option_of_integers_place_holder(): void
    {
        $card = CardBuilder::create()
            ->withChoicesPlaceholder('option', [1, 2, 3])
            ->buildCard(['option' => [2]]);

        self::assertSame('choice(2)', $card->getVariableValue('option')->toTypedString());
    }

    public function test_it_should_build_card_with_option_of_floats_place_holder(): void
    {
        $card = CardBuilder::create()
            ->withChoicesPlaceholder('option', [12.34, 56.78, 90.12])
            ->buildCard(['option' => [12.34]]);

        self::assertSame('choice(12.34)', $card->getVariableValue('option')->toTypedString());
    }
}
