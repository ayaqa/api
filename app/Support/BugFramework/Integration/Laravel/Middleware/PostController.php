<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Context\Event\AppStepUpdated;
use Closure;
use Illuminate\Http\JsonResponse;

class PostController
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        event(AppStepUpdated::toStep(AppStep::POST_CONTROLLER));

        if ($response instanceof JsonResponse) {
            // @TODO
        }

        return $response;
    }
}
