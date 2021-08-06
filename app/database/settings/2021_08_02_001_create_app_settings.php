<?php

use AyaQA\Core\Literal\SettingConst;
use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

class CreateAppSettings extends SettingsMigration
{
    public function up()
    {
        $this->migrator->inGroup(SettingConst::APP_GROUP, function (SettingsBlueprint $blueprint): void {
            $blueprint->add('create_session', true);
            $blueprint->add('list_sessions', true);
            $blueprint->add('is_protected', false);
            $blueprint->addEncrypted('password', SettingConst::DEFAULT_PASSWORD);
            $blueprint->add('session_limit', SettingConst::DEFAULT_MAX_SESSIONS);
        });
    }
}
