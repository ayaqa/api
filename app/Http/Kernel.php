<?php

namespace AyaQA\Http;

use AyaQA\Http\Core\Middleware\UrlTenantResolver;
use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        Core\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        Core\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
        'tenant' => [
            \Spatie\Multitenancy\Http\Middleware\NeedsTenant::class,
            \AyaQA\Http\Core\Middleware\TenantRequestedAt::class
        ]
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'core.password' => \AyaQA\Http\Core\Middleware\CorePasswordChecker::class,
    ];
}
