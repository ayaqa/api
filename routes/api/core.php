<?php

use AyaQA\Http\Core\Controllers\BugController;
use AyaQA\Http\Core\Controllers\HomeController;
use AyaQA\Http\Core\Controllers\TenantController;
use Illuminate\Support\Facades\Route;

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

Route::prefix('bugs')->middleware('tenant')->group(function() {
    Route::get('/', [BugController::class, 'getBugs'])->name('bug.bugs');
    Route::post('/', [BugController::class, 'storeBugs'])->name('bug.store');

    Route::get('/manifest', [BugController::class, 'manifest'])->name('bug.manifest');
    Route::get('/ui', [BugController::class, 'getUIBugs'])->name('bug.ui');
});
