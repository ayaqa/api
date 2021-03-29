<?php

namespace AyaQA\Module\Bug\Http\Controller;

use Illuminate\Http\Request;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Config\Repository as Config;
use Illuminate\Routing\Controller as BaseController;

class InfoController extends BaseController
{
    public function index(Request $request, ResponseFactory $responseFactory, Config $config)
    {
        return $responseFactory->json([
            'version' => $config->get('bug.version'),
            'bugs_count' => 0
        ]);
    }
}
