<?php

use App\Http\Controllers\NotebookController;

Route::prefix('v1')->group(function () {
    Route::get('notebook', [NotebookController::class, 'index']);
    Route::get('notebook/{id}', [NotebookController::class, 'show']);
    Route::post('notebook', [NotebookController::class, 'store']);
    Route::put('notebook/{id}', [NotebookController::class, 'update']);
    Route::delete('notebook/{id}', [NotebookController::class, 'destroy']);
});