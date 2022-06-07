<?php

namespace AyaQA\Services\Core;

use AyaQA\Enum\Core\TenantState;
use AyaQA\Models\Core\Tenant;
use AyaQA\Settings\Core\CoreSettings;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Date;

class TenantService
{
    public function __construct(
        private CoreSettings $settings,
    ){}

    public function create(): Tenant
    {
        do {
            $dbName = sprintf('ts-%s.sqlite', mt_rand(5, 500000));
        } while(Tenant::sessions()->where('database', $dbName)->exists());

        do {
            $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        } while(Tenant::sessions()->where('session', $uuid)->exists());

        return Tenant::create([
            'database' => $dbName,
            'session' =>  $uuid,
            'state' => TenantState::CREATED,
            'deletable' => 1,
            'requested_at' => Date::now('UTC'),
        ]);
    }

    public function getReadyForAutoDelete(): Collection
    {
        $tenants = collect();
        if ($this->settings->autoDeleteSession) {
            $tenants = Tenant::forAutoDelete($this->settings->sessionDeleteAfter)->get();
        }

        return $tenants;
    }


    public function canCreateSession(): bool
    {
        $foundSessions = Tenant::sessions()->count();

        return $this->settings->sessionsLimit > $foundSessions;
    }
}
