<?php

namespace AyaQA\Settings\Core;

use Spatie\LaravelSettings\Settings;

class CoreSettings extends Settings
{
    public const GROUP = 'c';

    // if setting change is password protected
    public bool $changeSettingsPassword;

    // if listing global settings requires password
    public bool $listSettingsPassword;

    // if is allowed to list available sessions without password
    public bool $listSessions;

    // if sessions have to be deleted once are not used anymore
    public bool $autoDeleteSession;

    // timeout after which session will be deleted if no requests.
    public int $sessionDeleteAfter; // in sec

    // total allowed session for that instance
    public int $sessionsLimit;

    // global admin password
    public string $password;

    protected array $hiddenToArray = ['password'];

    public static function group(): string
    {
        return self::GROUP;
    }

    public function toArray(): array
    {
        return $this->toCollection()->except($this->hiddenToArray)->toArray();
    }
}
