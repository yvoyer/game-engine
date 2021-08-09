<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class ChoicesOfMixedTypeTest extends TestCase
{
    public function test_it_should_throw_exception_when_not_authorized_values_given(): void
    {
        $this->expectException(InvalidAuthorizedChoices::class);
        $this->expectExceptionMessage('Cannot have empty selected options.');
        CardBuilder::create()->withChoicesVariable('choices', [], []);
    }

    public function test_it_should_throw_exception_when_values_are_not_all_of_same_type(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value "12" expected to be string, type integer given.');
        CardBuilder::create()->withChoicesVariable('choices', ['string'], ['string', 12]);
    }

    public function test_it_should_throw_exception_when_selected_values_are_not_in_authorized_values(): void
    {
        $this->expectException(InvalidAuthorizedChoices::class);
        $this->expectExceptionMessage(
            'Some values in "choice(selected)" are not in the authorized values "choice(authorized)".'
        );
        CardBuilder::create()->withChoicesVariable('choices', ['selected'], ['authorized']);
    }

    public function test_it_should_build_card_with_option_of_strings(): void
    {
        $card = CardBuilder::create()
            ->withChoicesVariable('option', ['two'], ['one', 'two', 'three'])
            ->buildCard();

        self::assertSame('choice(two)', $card->getVariableValue('option')->toTypedString());
    }

    public function test_it_should_build_card_with_option_of_integers(): void
    {
        $card = CardBuilder::create()
            ->withChoicesVariable('option', [2], [1, 2, 3])
            ->buildCard();

        self::assertSame('choice(2)', $card->getVariableValue('option')->toTypedString());
    }

    public function test_it_should_build_card_with_option_of_floats(): void
    {
        $card = CardBuilder::create()
            ->withChoicesVariable('option', [12.34], [12.34, 56.78, 90.12])
            ->buildCard();

        self::assertSame('choice(12.34)', $card->getVariableValue('option')->toTypedString());
    }
}
