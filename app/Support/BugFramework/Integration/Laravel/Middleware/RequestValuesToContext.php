<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Context\BugContextSetter;
use AyaQA\Support\BugFramework\Integration\RequestParam;
use Illuminate\Http\Request;

class RequestValuesToContext
{
    public function __construct(
        private BugContextSetter $contextSetter
    ) {}

    /**
     * @param Request $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next): mixed
    {
        $this->fillRequestResourceId($request);
        $this->fillRequestParameters($request);

        return $next($request);
    }

    protected function fillRequestParameters(Request $request)
    {
        $params = $request->all();
        $this->contextSetter->set(BugTarget::PARAMETER, $params);
    }

    protected function fillRequestResourceId(Request $request)
    {
        $resourceIdKey = RequestParam::RESOURCE_ID->asParamKey();
        if ($request->has($resourceIdKey)) {
            $this->contextSetter->set(BugTarget::RESOURCE_ID, $request->get($resourceIdKey));

            $request->request->remove($resourceIdKey);
        }
    }
}
