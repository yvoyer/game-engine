<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\Prototyping\MissingPlaceholderValue;
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
        self::assertTrue($card->isValid($this->createMock(ErrorReader::class)));
        self::assertTrue($card->isValid());
    }

    public function test_it_should_define_custom_variable(): void
    {
        $card = CardBuilder::create()
            ->withTextVariable('name', 'value')
            ->buildCard();

        self::assertTrue($card->isValid());
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
}
