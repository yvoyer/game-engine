<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\Prototyping\Value\StringValue;
use Star\GameEngine\Component\Card\Shuffling\ReverseOrder;

final class DeckOfCardTest extends TestCase
{
    private const FIRST_CARD = 'first';
    private const SECOND_CARD = 'second';
    private const THIRD_CARD = 'third';
    private const FOURTH_CARD = 'fourth';
    private const LAST_CARD = 'last';

    /**
     * @var DeckOfCard
     */
    private $deck;

    protected function setUp(): void
    {
        $template = CardBuilder::create()
            ->withTextPlaceholder('name')
            ->endPlaceholder();

        $this->deck = new DeckOfCard(
            'deck-name',
            $template->buildCard(['name' => self::LAST_CARD]),
            $template->buildCard(['name' => self::FOURTH_CARD]),
            $template->buildCard(['name' => self::THIRD_CARD]),
            $template->buildCard(['name' => self::SECOND_CARD]),
            $template->buildCard(['name' => self::FIRST_CARD]),
        );
    }

    public function test_it_should_draw_the_top_card(): void
    {
        $card = $this->deck->drawTopCard();
        $this->assertSameCard(self::FIRST_CARD, $card);
    }

    public function test_it_should_return_the_number_of_card_remaining(): void
    {
        self::assertCount(5, $this->deck);
        $this->deck->drawTopCard();
        self::assertCount(4, $this->deck);
    }

    public function test_it_should_throw_exception_when_no_more_card(): void
    {
        $this->deck->drawTopCard();
        $this->deck->drawTopCard();
        $this->deck->drawTopCard();
        $this->deck->drawTopCard();
        $this->deck->drawTopCard();

        $this->expectException(EmptyDeck::class);
        $this->expectExceptionMessage('Deck "deck-name" is empty, cannot draw any cards.');
        $this->deck->drawTopCard();
    }

    public function test_it_should_draw_number_of_card(): void
    {
        $cards = $this->deck->drawTopCards(3);
        self::assertCount(2, $this->deck);
        self::assertCount(3, $cards);
    }

    public function test_it_should_iterate_over_all_the_cards(): void
    {
        $visitor = $this->createMock(DeckVisitor::class);
        $visitor
            ->expects(self::exactly(5))
            ->method('visitCard');

        $this->deck->acceptDeckVisitor($visitor);
    }

    public function test_it_should_stop_as_soon_as_a_visit_returns_true(): void
    {
        $visitor = $this->createMock(DeckVisitor::class);
        $visitor
            ->expects(self::exactly(2))
            ->method('visitCard')
            ->willReturnOnConsecutiveCalls(false, true);

        $this->deck->acceptDeckVisitor($visitor);
    }

    public function test_it_should_shuffle_deck(): void
    {
        $newDeck = $this->deck->shuffle(new ReverseOrder());

        $this->assertSameCard(self::FIRST_CARD, $this->deck->drawTopCard());
        $this->assertSameCard(self::SECOND_CARD, $this->deck->drawTopCard());
        $this->assertSameCard(self::THIRD_CARD, $this->deck->drawTopCard());
        $this->assertSameCard(self::FOURTH_CARD, $this->deck->drawTopCard());
        $this->assertSameCard(self::LAST_CARD, $this->deck->drawTopCard());

        $this->assertSameCard(self::LAST_CARD, $newDeck->drawTopCard());
        $this->assertSameCard(self::FOURTH_CARD, $newDeck->drawTopCard());
        $this->assertSameCard(self::THIRD_CARD, $newDeck->drawTopCard());
        $this->assertSameCard(self::SECOND_CARD, $newDeck->drawTopCard());
        $this->assertSameCard(self::FIRST_CARD, $newDeck->drawTopCard());
    }

    public function test_it_should_merge_deck_by_pushing_cards_at_bottom(): void
    {
        self::assertCount(5, $this->deck);
        self::assertCount(10, $this->deck->merge($this->deck));
        self::assertCount(5, $this->deck);
    }

    private function assertSameCard(string $name, Card $card): void
    {
        self::assertSame(
            StringValue::fromString($name)->toTypedString(),
            $card->getVariableValue('name')->toTypedString()
        );
    }
}
