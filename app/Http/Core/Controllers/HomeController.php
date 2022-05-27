<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Abstracts\Http\ApiController;
use AyaQA\Actions\Core\GetAppDetails;
use Illuminate\Http\JsonResponse;

class HomeController extends ApiController
{
    public function root(GetAppDetails $appDetails): JsonResponse
    {
        return response()->json($appDetails->handle());
    }
}
