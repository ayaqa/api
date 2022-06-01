<?php

use AyaQA\Settings\Core\CoreSettings;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class AddSettings extends SettingsMigration
{
    public function up()
    {
        $this->add('changeSettingsPassword', true);
        $this->add('listSettingsPassword', false);
        $this->add('listSessions', true);
        $this->add('autoDeleteSession', true);
        $this->add('sessionDeleteAfter', 3600);
        $this->add('sessionsLimit', 10);
        $this->add('password', 'ayaqa');
    }

    protected function add(string $setting, bool|int|string $defaultValue)
    {
        $this->migrator->add(
            sprintf('%s.%s', CoreSettings::GROUP, $setting),
            $defaultValue
        );
    }
}
