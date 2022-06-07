<?php

namespace AyaQA\Services\Core\Multitenancy;

use AyaQA\Actions\Core\Tenant\GetTenant;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use Illuminate\Http\Request;
use Spatie\Multitenancy\Models\Tenant;
use Spatie\Multitenancy\TenantFinder\TenantFinder;

class RequestTenantFinder extends TenantFinder
{
    const HEADER_SESSION_KEY = 'session';
    const GET_SESSION_KEY = 'session';

    public function __construct(
        private GetTenant $getTenant,
    ){}

    public function findForRequest(Request $request): ?Tenant
    {
        $tenant = null;
        if ($request->headers->has(self::HEADER_SESSION_KEY)) {
            $tenant = $this->findTenant($request->headers->get(self::HEADER_SESSION_KEY));
        }

        if ($request->has(self::GET_SESSION_KEY)) {
            $tenant = $this->findTenant($request->get(self::GET_SESSION_KEY));
        }

        if ($request->route()?->hasParameter(self::GET_SESSION_KEY)) {
            $tenant = $this->findTenant($request->route()->parameter(self::GET_SESSION_KEY));
        }

        return $tenant;
    }

    protected function findTenant(string $tenantIdentifier): ?Tenant
    {
        try {
            return $this->getTenant->handle($tenantIdentifier);
        } catch (NotFoundTenantException) {
            return null;
        }
    }
}
