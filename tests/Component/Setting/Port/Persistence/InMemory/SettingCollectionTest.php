<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Port\Persistence\InMemory;

use PHPUnit\Framework\TestCase;
use Star\GameEngine\Component\Setting\NotSupportedSetting;
use Star\GameEngine\Component\Setting\Value\StringValue;

final class SettingCollectionTest extends TestCase
{
    public function test_it_should_return_setting_value(): void
    {
        $settings = new SettingCollection(
            [
                'id' => StringValue::fromString('value'),
            ]
        );

        self::assertSame('value', $settings->getValue('id')->toString());
    }

    public function test_it_should_throw_exception_when_not_defined(): void
    {
        $settings = new SettingCollection([]);

        $this->expectException(NotSupportedSetting::class);
        $this->expectExceptionMessage('Setting "not-found" is not defined yet.');
        $settings->getValue('not-found');
    }
}
