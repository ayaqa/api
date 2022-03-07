<?php

namespace AyaQA\Http\Playground\Controllers;

use AyaQA\Models\Playground\Toggle;
use Illuminate\Http\Request;
use AyaQA\Abstracts\Http\ApiController;

class ToggleController extends ApiController
{
    public function single(Request $request)
    {
        $toggleId = $request->get('toggleId');

        $response = [];
        if(false === empty($toggleId)) {
            $response = Toggle::find($toggleId)->toArray();
        }

        return response()->json($response);
    }
}
