<?php

use AyaQA\Http\Core\Controllers\HomeController;
use AyaQA\Http\Core\Controllers\TenantController;
use AyaQA\Http\Core\Middleware\EnsureTenantIsSet;
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

Route::get('/', [HomeController::class, 'root'])->name('home');

Route::prefix('session')->group(function () {
    Route::post('/', [TenantController::class, 'create'])->name('session.create');
    Route::delete('/', [TenantController::class, 'delete'])->name('session.delete');
});
