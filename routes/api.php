<?php

use AyaQA\Http\Core\Controllers\DefaultController;
use AyaQA\Http\Core\Controllers\TenantController;
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

Route::get('/', [DefaultController::class, 'show'])->name('home');

Route::prefix('tenant')->group(function () {
    Route::get('/', [TenantController::class, 'info'])->name('tenant.info');
    Route::post('/', [TenantController::class, 'create'])->name('tenant.create');

    Route::delete('/', [TenantController::class, 'delete'])->name('tenant.delete');
});
