<?php

use AyaQA\Http\Playground\Controllers\ToggleController;

Route::prefix('playground')->middleware('tenant')->group(function () {
    Route::prefix('toggle')->group(function() {
        Route::get('/', [ToggleController::class, 'single'])->name('toggle.single');
    });
});
