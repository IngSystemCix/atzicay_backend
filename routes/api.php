<?php

use App\Infrastructure\Http\Controllers\AssessmentController;

Route::prefix('atzicay/v1')->group(function () {
    Route::post('/assessments', [AssessmentController::class, 'createAssessment']);
});