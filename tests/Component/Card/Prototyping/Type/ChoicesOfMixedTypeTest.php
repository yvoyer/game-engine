<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class ChoicesOfMixedTypeTest extends TestCase
{
    public function test_it_should_throw_exception_when_not_authorized_values_given(): void
    {
        $this->expectException(InvalidAuthorizedChoices::class);
        $this->expectExceptionMessage('dadas');
        CardBuilder::create()->withChoicesVariable('choices', [], []);
    }

    public function test_it_should_throw_exception_when_values_are_not_all_of_same_type(): void
    {
        $this->expectException(InvalidAuthorizedChoices::class);
        $this->expectExceptionMessage('dadas');
        CardBuilder::create()->withChoicesVariable('choices', [], ['string', 12]);
    }

    public function test_it_should_throw_exception_when_selected_values_are_not_in_authorized_values(): void
    {
        $this->expectException(InvalidAuthorizedChoices::class);
        $this->expectExceptionMessage('dadas');
        CardBuilder::create()->withChoicesVariable('choices', ['invalid'], ['string']);
    }

    public function test_it_should_build_card_with_option_of_strings(): void
    {
        $card = CardBuilder::create()
            ->withChoicesVariable('option', ['two'], ['one', 'two', 'three'])
            ->buildCard();

        self::assertSame('stringArray(two)', $card->getVariableValue('option')->toTypedString());
    }

    public function test_it_should_build_card_with_option_of_integers(): void
    {
        $card = CardBuilder::create()
            ->withChoicesVariable('option', [2], [1, 2, 3])
            ->buildCard();

        self::assertSame('integerArray(2)', $card->getVariableValue('option')->toTypedString());
    }

    public function test_it_should_build_card_with_option_of_floats(): void
    {
        $card = CardBuilder::create()
            ->withChoicesVariable('option', [12.34], [12.34, 56.78, 90.12])
            ->buildCard();

        self::assertSame('floatArray(12.34)', $card->getVariableValue('option')->toTypedString());
    }
}
