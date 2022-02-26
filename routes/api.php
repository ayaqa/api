<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function (Request $request) {
    $tenant = new \App\Models\Core\Tenant();
    $tenant->database = 'test_'.mt_rand(100, 500000);
    $tenant->session = \Ramsey\Uuid\Uuid::uuid4()->toString();
    $tenant->state = 'created';

    $tenant->save();
});
