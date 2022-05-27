<?php

namespace AyaQA\Services\Core\Multitenancy;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Multitenancy\Models\Concerns\UsesTenantModel;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class RequestTenantFinder extends TenantFinder
{
    use UsesTenantModel;

    const HEADER_SESSION_KEY = 'session';
    const GET_SESSION_KEY = 'session';

    public function findForRequest(Request $request): ?Tenant
    {
        $tenant = null;
        if ($request->headers->has(self::HEADER_SESSION_KEY)) {
            $tenant = $this->findTenant($request->headers->get(self::HEADER_SESSION_KEY));
        }

        if ($request->has(self::GET_SESSION_KEY)) {
            $tenant = $this->findTenant($request->get(self::GET_SESSION_KEY, null));
        }

        return $tenant;
    }

    protected function findTenant(string $tenantIdentifier): ?Tenant
    {
        return $this->getTenantModel()->newQuery()->where(function(Builder $query) use ($tenantIdentifier) {
            $query->where('id', '=', $tenantIdentifier)->orWhere('session', '=', $tenantIdentifier);
        })->first();
    }
}
