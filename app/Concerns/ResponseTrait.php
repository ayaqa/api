<?php

namespace AyaQA\Concerns;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;

trait ResponseTrait
{
    protected function respond(mixed $responseData): JsonResponse
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
