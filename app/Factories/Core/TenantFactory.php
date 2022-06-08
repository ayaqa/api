<?php

namespace AyaQA\Factories\Core;

use AyaQA\Abstracts\Factory;
use AyaQA\Enum\Core\TenantState;
use AyaQA\Models\Core\Tenant;
use AyaQA\Settings\Core\CoreSettings;
use Illuminate\Support\Facades\Date;

class TenantFactory extends Factory
{
    public function create(array $overrides = []): Tenant
    {
        do {
            $dbName = sprintf('ts-%s.sqlite', mt_rand(5, 500000));
        } while(Tenant::query()->dbExists($dbName));

        do {
            $uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
        } while(Tenant::query()->sessionExists($uuid));

        return Tenant::create(array_merge([
            'database' => $dbName,
            'session' =>  $uuid,
            'state' => TenantState::CREATED,
            'deletable' => 1,
            'requested_at' => Date::now('UTC'),
        ], $overrides));
    }

    public function isAllowedToCreate(CoreSettings $coreSettings): bool
    {
        $foundSessions = Tenant::query()->sessions()->count();

        return $coreSettings->sessionsLimit > $foundSessions;
    }
}
