<?php declare(strict_types=1);

namespace Star\GameEngine\Component\Setting\Port\Persistence\InMemory;

use Star\GameEngine\Component\Setting\NotSupportedSetting;
use Star\GameEngine\Component\Setting\SettingStore;
use Star\GameEngine\Component\Setting\SettingValue;
use function array_key_exists;
use function sprintf;

final class SettingCollection implements SettingStore
{
    /**
     * @var SettingValue[] Indexed by id
     */
    private $values;

    /**
     * @param SettingValue[] $values Indexed by id
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    public function getValue(string $setting): SettingValue
    {
        if (! array_key_exists($setting, $this->values)) {
            throw new NotSupportedSetting(
                sprintf('Setting "%s" is not defined yet.', $setting)
            );
        }

        return $this->values[$setting];
    }
}
