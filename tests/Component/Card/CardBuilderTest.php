<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\Prototyping\UndefinedVariable;
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

    public function test_it_should_throw_exception_when_variable_not_defined(): void
    {
        $builder = CardBuilder::create()->buildCard();

        $this->expectException(UndefinedVariable::class);
        $this->expectExceptionMessage('Variable "var" is not defined.');
        $builder->getVariableValue('var');
    }
}
