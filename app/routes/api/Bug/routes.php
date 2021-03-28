<?php

use Illuminate\Support\Facades\Route;

Route::prefix('bug')->group(function () {
    Route::get('/version', [\AyaQA\Module\Bug\Http\Controller\VersionController::class, 'index'])->name('version');
});
