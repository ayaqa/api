<?php

namespace AyaQA\Http\Core\Middleware;

use AyaQA\Models\Core\Tenant;
use Illuminate\Support\Facades\Date;

class TenantRequestedAt
{
    public function handle($request, \Closure $next)
    {
        $tenant = Tenant::current();
        $now = Date::now('UTC');

        // update once every 30 secs
        if ($tenant && $now->diffInSeconds($tenant->requested_at) > 30) {
            $tenant->requested_at = $now;
            $tenant->save();
        }

        return $next($request);
    }
}
