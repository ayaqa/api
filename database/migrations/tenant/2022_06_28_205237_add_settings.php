<?php

use AyaQA\Settings\Core\TenantSettings;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddSettings extends SettingsMigration
{
    public function up()
    {
        // hack to force proper repo
        $this->migrator = $this->migrator->repository('tenant');

        $this->add('changeSettingsPassword', true);
        $this->add('listSettingsPassword', false);
        $this->add('password', 'ayaqa');
    }

    protected function add(string $setting, bool|int|string $defaultValue)
    {
        $this->migrator->add(
            sprintf('%s.%s', TenantSettings::GROUP, $setting),
            $defaultValue
        );
    }
}
