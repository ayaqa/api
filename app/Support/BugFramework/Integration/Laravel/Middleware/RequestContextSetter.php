<?php

namespace AyaQA\Support\BugFramework\Integration\Laravel\Middleware;

use AyaQA\Support\BugFramework\Context\BugContextSetter;
use AyaQA\Support\BugFramework\Value\ValueType;
use Illuminate\Http\Request;

class RequestContextSetter
{
    public function __construct(
        private BugContextSetter $contextSetter
    ) {}

    /**
     * @param Request $request
     *
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle($request, \Closure $next): mixed
    {
        $this->setHeaders($request);
        $this->setGetParams($request);
        $this->setPostParams($request);
        $this->setRequestData($request);

        return $next($request);
    }

    protected function setHeaders(Request $request)
    {
        $headers = $request->headers->all();
        if (false === empty($headers)) {
            $normalisedHeaders = [];
            foreach ($headers as $headerKey => $headerValue) {
                if (count($headerValue) === 1 && is_string($headerValue[0])) {
                    $normalisedHeaders[$headerKey] = $headerValue[0];
                }
            }

            $this->contextSetter->set(ValueType::HEADER_PARAM, $normalisedHeaders);
        }
    }

    protected function setGetParams(Request $request)
    {
        $params = $request->query->all();
        $params = \Arr::dot($params);

        $this->contextSetter->set(ValueType::GET_PARAM, $params);
    }

    protected function setPostParams(Request $request)
    {
        $params = $request->request->all();
        $params = \Arr::dot($params);

        $this->contextSetter->set(ValueType::POST_PARAM, $params);
    }

    protected function setRequestData(Request $request)
    {
        $this->contextSetter->set(ValueType::REQUEST_TYPE, [$request->getMethod()]);
        $this->contextSetter->set(ValueType::CLIENT_IP, [$request->getClientIp() ?: '']);
    }
}
