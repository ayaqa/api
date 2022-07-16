<?php

use AyaQA\Http\Core\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'root'])->name('home');

Route::prefix('session')->group(function () {
    Route::post('/', [TenantController::class, 'create'])->name('session.create');
    Route::get('/{session}', [TenantController::class, 'get'])->name('session.get');

    Route::middleware('core.password:true')->group(function() {
            Route::delete('/{session}', [TenantController::class, 'delete'])->name('session.delete');
            Route::patch('/{session}/deletable', [TenantController::class, 'deletable'])->name('session.update.deletable');
        }
    );
});
