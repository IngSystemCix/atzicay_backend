<?php
use App\Infrastructure\Http\Controllers\AssessmentController;
use App\Infrastructure\Http\Controllers\HangmanController;

Route::prefix('atzicay/v1')->group(function () {
    // Routes for assessments
    Route::get('/assessments', [AssessmentController::class, 'getAllAssessments']);
    Route::get('/assessments/{id}', [AssessmentController::class, 'getAssessmentsById']);
    Route::post('/assessments', [AssessmentController::class, 'createAssessment']);
    Route::post('/hangman', [HangmanController::class,'createHangman']);
});