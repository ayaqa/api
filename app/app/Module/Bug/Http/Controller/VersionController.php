<?php

namespace AyaQA\Module\Bug\Http\Controller;

use Illuminate\Routing\ResponseFactory;
use Illuminate\Config\Repository as Config;
use Illuminate\Routing\Controller as BaseController;

class VersionController extends BaseController
{
    public function index(ResponseFactory $responseFactory, Config $config)
    {
        return $responseFactory->json([
            'version' => $config->get('bug.version')
        ]);
    }
}
