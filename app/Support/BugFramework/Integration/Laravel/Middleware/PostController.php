<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\AppFlowStep;
use AyaQA\Support\BugFramework\Context\Event\AppFlowStepUpdated;
use Closure;
use Illuminate\Http\JsonResponse;

class PostController
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        event(AppFlowStepUpdated::toStep(AppFlowStep::POST_CONTROLLER));

        if ($response instanceof JsonResponse) {
            // @TODO
        }

        return $response;
    }
}
