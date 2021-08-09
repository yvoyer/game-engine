<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Card\Prototyping\Type;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Card\CardBuilder;

final class StringTypeTest extends TestCase
{
    public function test_it_should_define_custom_variable(): void
    {
        $card = CardBuilder::create()
            ->withTextVariable('name', 'value')
            ->buildCard();

        self::assertSame('string(value)', $card->getVariableValue('name')->toTypedString());
    }
}
