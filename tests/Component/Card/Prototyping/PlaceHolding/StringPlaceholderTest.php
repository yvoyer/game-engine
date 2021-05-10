<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\PlaceHolding;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class StringPlaceholderTest extends TestCase
{
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
