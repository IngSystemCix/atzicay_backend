<?php

use App\Infrastructure\Http\Controllers\AssessmentController;
use App\Infrastructure\Http\Controllers\HangmanController;

Route::prefix('atzicay/v1')->group(function () {
    Route::post('/assessments', [AssessmentController::class, 'createAssessment']);
});
Route::prefix('atzicay/v1')->group(function () {
    Route::post('/hangman', [HangmanController::class,'createHangman']);
});