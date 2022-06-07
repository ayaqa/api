<?php

namespace AyaQA\Abstracts\Http;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Routing\Controller as BaseController;

abstract class ApiController extends BaseController
{
    protected function respond(mixed $responseData)
    {
        $toArray = [];
        if ($responseData instanceof Arrayable) {
            $toArray = $responseData->toArray();
        }

        if (is_array($responseData)) {
            $toArray = $responseData;
        }

        return response()->json($toArray);
    }
}
