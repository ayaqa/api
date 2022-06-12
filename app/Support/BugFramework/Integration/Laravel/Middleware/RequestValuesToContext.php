<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\BugTarget;
use AyaQA\Support\BugFramework\Context\BugContext;
use AyaQA\Support\BugFramework\Integration\RequestParamType;
use AyaQA\Support\BugFramework\Value\Factory\ValueFactory;
use Illuminate\Http\Request;

class RequestValuesToContext
{
    public function __construct(
        private BugContext $bugContext,
        private ValueFactory $valueFactory
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
        $collection = $this->valueFactory->createCollection(BugTarget::PARAMETER, $params);
        $this->bugContext->setCollection(BugTarget::PARAMETER, $collection);
    }

    protected function fillRequestResourceId(Request $request)
    {
        $resourceIdKey = RequestParamType::RESOURCE_ID->getParamKey();
        if ($request->has($resourceIdKey)) {
            $value = $this->valueFactory->createResourceId($request->get($resourceIdKey));
            $this->bugContext->setValue(BugTarget::RESOURCE_ID, $value);

            $request->request->remove($resourceIdKey);
        }
    }
}
