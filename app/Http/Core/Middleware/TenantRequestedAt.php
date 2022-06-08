<?php

namespace AyaQA\Http\Core\Middleware;

use AyaQA\Actions\Core\Tenant\GetCurrentTenantAction;
use AyaQA\Exceptions\Core\NotFoundTenantException;
use Illuminate\Support\Facades\Date;

class TenantRequestedAt
{
    public function __construct(
        private GetCurrentTenantAction $getCurrentTenantAction
    ) { }

    public function handle($request, \Closure $next)
    {
        try {
            $tenant = $this->getCurrentTenantAction->handle();

            $now = Date::now('UTC');

            // update once every 30 secs
            if ($now->diffInSeconds($tenant->requested_at) > 30) {
                $tenant->requested_at = $now;
                $tenant->save();
            }

        } catch (NotFoundTenantException) {
        }

        return $next($request);
    }
}
