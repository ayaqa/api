<?php

use AyaQA\Http\Playground\Controllers\Checkbox\RemindersController;
use AyaQA\Http\Playground\Controllers\Checkbox\TechnologiesController;
use AyaQA\Http\Playground\Controllers\Checkbox\TocController;

Route::prefix('playground')->middleware(['tenant', 'buggable'])->group(function () {
    Route::prefix('checkbox')->group(function() {
        Route::get('/toc', [TocController::class, 'get'])->name('toc.get');
        Route::post('/toc', [TocController::class, 'set'])->name('toc.set');

        Route::get('/technologies', [TechnologiesController::class, 'get'])->name('technologies.get');
        Route::post('/technologies', [TechnologiesController::class, 'set'])->name('technologies.set');

        Route::get('/reminders', [RemindersController::class, 'get'])->name('reminders.get');
        Route::post('/reminders', [RemindersController::class, 'set'])->name('reminders.set');
    });
});
