<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class IntegerTypeTest extends TestCase
{
    public function test_it_should_build_card_with_integer_variable(): void
    {
        $card = CardBuilder::create()
            ->withIntegerVariable('key', 123)
            ->buildCard();

        self::assertSame(
            'integer(123)',
            $card->getVariableValue('key')->toTypedString()
        );
    }
}
