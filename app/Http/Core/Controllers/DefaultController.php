<?php

namespace AyaQA\Http\Core\Controllers;

use AyaQA\Abstracts\Http\ApiController;
use Illuminate\Http\Request;

class DefaultController extends ApiController
{
    public function show(Request $request) {
        return response()->json(['ok']);
    }
}
