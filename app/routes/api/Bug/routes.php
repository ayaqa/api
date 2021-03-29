<?php

use Illuminate\Support\Facades\Route;

Route::prefix('bug')->group(function () {
    Route::get('/info', [\AyaQA\Module\Bug\Http\Controller\InfoController::class, 'index'])->name('version');
});
