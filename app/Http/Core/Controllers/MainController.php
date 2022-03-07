<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Abstracts\Http\ApiController;
use Illuminate\Http\Request;

class MainController extends ApiController
{
    public function info(Request $request)
    {
        return response()->json(['ok']);
    }
}
