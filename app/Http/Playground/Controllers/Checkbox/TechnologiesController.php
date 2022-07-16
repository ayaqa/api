<?php

namespace AyaQA\Http\Playground\Controllers\Checkbox;

use Illuminate\Http\Request;

class TechnologiesController
{
    public function get(Request $request)
    {
        // @TODO return state
    }

    public function set(Request $request)
    {
        $state = $request->get('checked', false);

        // @TODO update and return state
    }
}
