<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Actions\Core\GetAppDetails;
use AyaQA\Concerns\ResponseTrait;
use Illuminate\Http\JsonResponse;

class HomeController
{
    use ResponseTrait;

    public function root(GetAppDetails $appDetails): JsonResponse
    {
        return $this->respond($appDetails());
    }
}
