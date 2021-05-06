<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\Prototyping\PlaceHolding\MissingPlaceholderValue;
use Star\GameEngine\Component\Card\Reading\CardReader;

final class CardBuilderTest extends TestCase
{
    public function test_it_should_build_a_card_with_no_requirement(): void
    {
        $card = CardBuilder::create()->buildCard();

        self::assertInstanceOf(Card::class, $card);
        $card->acceptCardVisitor($reader = new CardReader());

        self::assertCount(0, $reader->getVariables());
        self::assertCount(0, $reader->getBehaviors());
    }

    public function test_it_should_define_custom_variable(): void
    {
        $card = CardBuilder::create()
            ->withTextVariable('name', 'value')
            ->buildCard();

        self::assertSame('string(value)', $card->getVariableValue('name')->toTypedString());
    }

    public function test_it_should_define_custom_placeholder_that_allow_placing_values_afterward(): void
    {
        $card = CardBuilder::create()
            ->withTextPlaceholder('name')
            ->buildCard(
                ['name' => 'value']
            );

        self::assertSame('string(value)', $card->getVariableValue('name')->toTypedString());
    }

    public function test_it_should_throw_exception_when_required_placeholder_is_missing(): void
    {
        $builder = CardBuilder::create()
            ->withTextPlaceholder('name');

        $this->expectException(MissingPlaceholderValue::class);
        $this->expectExceptionMessage(
            'The placeholder with name "name", requires a value to be given in the data, "[]" given.'
        );
        $builder->buildCard();
    }

    public function test_it_should_build_card_with_integer_variable(): void
    {
        $card = CardBuilder::create()
            ->withIntegerVariable('key', 123)
            ->buildCard();

        self::assertSame('integer(123)', $card->getVariableValue('key')->toTypedString());
    }

    public function test_it_should_build_card_with_integer_place_holder(): void
    {
        $card = CardBuilder::create()
            ->withIntegerPlaceholder('key')
            ->buildCard(['key' => 123]);

        self::assertSame('integer(123)', $card->getVariableValue('key')->toTypedString());
    }

    public function test_it_should_build_card_with_boolean_variable(): void
    {
        $card = CardBuilder::create()
            ->withBooleanVariable('key', true)
            ->buildCard();

        self::assertSame('boolean(true)', $card->getVariableValue('key')->toTypedString());
    }

    public function test_it_should_build_card_with_boolean_place_holder(): void
    {
        $card = CardBuilder::create()
            ->withBooleanPlaceholder('key')
            ->buildCard(['key' => false]);

        self::assertSame('boolean(false)', $card->getVariableValue('key')->toTypedString());
    }
}
