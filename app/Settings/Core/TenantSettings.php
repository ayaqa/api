<?php

namespace AyaQA\Settings\Core;

use Spatie\LaravelSettings\Settings;

class TenantSettings extends Settings
{
    public const GROUP = 't';

    // if setting change is password protected
    public bool $changeSettingsPassword;

    // if listing settings requires password
    public bool $listSettingsPassword;

    public string $password;

    protected array $hiddenToArray = ['password'];

    public static function group(): string
    {
        return self::GROUP;
    }

    public static function repository(): ?string
    {
        return 'tenant';
    }

    public function toArray(): array
    {
        return $this->toCollection()->except($this->hiddenToArray)->toArray();
    }
}
