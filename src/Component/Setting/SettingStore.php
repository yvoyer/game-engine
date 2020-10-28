<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting;

interface SettingStore
{
    public function getValue(string $setting): SettingValue;
}
