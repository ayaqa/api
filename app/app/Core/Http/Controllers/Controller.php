<?php

namespace AyaQA\Core\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Routing\ResponseFactory;

class Controller extends BaseController
{
    public function index(Request $request, ResponseFactory $responseFactory)
    {
        return $responseFactory->json([
            'status' => 'ok',
        ]);
    }
}
