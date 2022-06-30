<?php

namespace AyaQA\Support\Bug\Integration\Laravel\Middleware;

use AyaQA\Support\Bug\Context\BugContextSetter;
use AyaQA\Support\Bug\Field\BugField;
use AyaQA\Support\Bug\Integration\ParameterKey;
use Illuminate\Http\Request;

class SetContextFromRequest
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
        $this->setRequestParams($request);
        $this->setRequestHeaders($request);
        $this->setRequestParam($request);

        return $next($request);
    }

    public function setRequestParams(Request $request)
    {
        $params = $request->except([
            ParameterKey::PAGE_ID->asKey(),
        ]);

        $this->contextSetter->set(BugField::PARAMETER, $params);
    }

    public function setRequestHeaders(Request $request)
    {
        $headers = $request->headers->all();
        if (false === empty($headers)) {
            $normalisedHeaders = [];
            foreach ($headers as $headerKey => $headerValue) {
                if (count($headerValue) === 1 && is_string($headerValue[0])) {
                    $normalisedHeaders[$headerKey] = $headerValue[0];
                }
            }

            $this->contextSetter->set(BugField::HEADER, $normalisedHeaders);
        }
    }

    public function setRequestParam(Request $request)
    {
        $params = [
            ParameterKey::PAGE_ID->asKey() => BugField::PAGE_ID,
        ];

        foreach ($params as $paramKey => $field) {
            if ($request->has($paramKey)) {
                $this->contextSetter->set($field, $request->get($paramKey));
            }
        }
    }
}
