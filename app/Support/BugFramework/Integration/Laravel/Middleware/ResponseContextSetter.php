<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\Context\BugContextSetter;
use AyaQA\Support\BugFramework\Value\ValueType;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponseContextSetter
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
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $this->setResponseParams($response);
        }

        return $response;
    }

    protected function setResponseParams(JsonResponse $response)
    {
        $params = $response->getData(true);
        $params = \Arr::dot($params);

        $this->contextSetter->set(ValueType::RESPONSE_PARAM, $params);
    }
}
