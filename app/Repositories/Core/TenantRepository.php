<?php

namespace AyaQA\Repositories\Core;

use AyaQA\Enum\Core\TenantState;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use AyaQA\Models\Core\Tenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Date;

class TenantRepository
{
    public function databaseExists(string $databaseName): bool
    {
        return Tenant::where('database', $databaseName)->exists();
    }

    public function sessionExists(string $sessionUuid): bool
    {
        return Tenant::where('session', $sessionUuid)->exists();
    }

    public function delete(Tenant $tenant): Tenant
    {
        $tenant->state = TenantState::DELETING;
        $tenant->delete();
        $tenant->save();

        return $tenant;
    }

    public function create(string $dbName, string $sessionId): Tenant
    {
        return Tenant::create([
            'database' => $dbName,
            'session' =>  $sessionId,
            'state' => TenantState::CREATED,
            'requested_at' => Date::now('UTC'),
        ]);
    }

    public function setState(Tenant $tenant, TenantState $state): Tenant
    {
        $tenant->state = $state;
        $tenant->save();

        return $tenant;
    }

    /**
     * @throws NotFoundTenantException
     */
    public function get(string $tenantIdentifier, bool $withDeleted = false): Tenant
    {
        $tenant = Tenant::withTrashed($withDeleted)
            ->whereNot('state', TenantState::DELETING)
            ->where(function(Builder $query) use ($tenantIdentifier) {
                $query->where('id', '=', $tenantIdentifier)->orWhere('session', '=', $tenantIdentifier);
            })->first();

        if (null === $tenant) {
            throw new NotFoundTenantException(
                sprintf('Tenant with identifier %s was not found.', $tenantIdentifier)
            );
        }

        return $tenant;
    }

    public function getAllForAutoDeleting(int $idleInSeconds): ?Collection
    {
        return Tenant::where('requested_at', '<=', Date::now('UTC')->subSeconds($idleInSeconds)->toDateTimeString())->get();
    }
}
