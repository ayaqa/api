<?php

namespace AyaQA\Core\Settings;

use AyaQA\Core\Literal\SettingConst;
use Spatie\LaravelSettings\Settings;

class AppSettings extends Settings
{
    public bool   $create_session = true;
    public bool   $list_sessions = true;
    public bool   $is_protected = false;
    public int    $session_limit = SettingConst::DEFAULT_MAX_SESSIONS;
    public string $password = SettingConst::DEFAULT_PASSWORD;

    public static function group(): string
    {
        return SettingConst::APP_GROUP;
    }

    public static function encrypted(): array
    {
        return [
            'password',
        ];
    }

    public function asArray(): array
    {
        return [
            'can_create_session' => $this->create_session,
            'can_list_sessions' => $this->list_sessions,
            'is_protected' => $this->is_protected,
            'session_limit' => $this->session_limit,
        ];
    }
}
