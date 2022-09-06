<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use Arr;
use AyaQA\Support\BugFramework\AppStep;
use AyaQA\Support\BugFramework\Bug\BugManager;
use AyaQA\Support\BugFramework\Bug\Enum\ParamType;
use AyaQA\Support\BugFramework\Context\Event\AppStepUpdated;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController
{
    public function __construct(
        private BugManager $bugManager
    ){}

    /**
     * @param Request $request
     * @param Closure $next
     *
     * @return JsonResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        event(AppStepUpdated::toStep(AppStep::POST_CONTROLLER));

        if ($response instanceof JsonResponse) {
            $this->handleParamReplace($response);
        }

        return $response;
    }

    protected function handleParamReplace(JsonResponse $response): void
    {
        $postParams = $this->bugManager->getModifiedParameters(ParamType::RESPONSE);
        if (empty($postParams)) {
            return;
        }

        $data = Arr::dot($response->getData(true));
        foreach ($postParams as $key => $value) {
            $data[$key] = $value;
        }

        $response->setData(Arr::undot($data));
    }
}
