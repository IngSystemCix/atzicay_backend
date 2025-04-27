<?php
use App\Infrastructure\Http\Controllers\AssessmentController;
use App\Infrastructure\Http\Controllers\CountryController;

Route::prefix('atzicay/v1')->group(function () {
    // Routes for assessments
    Route::get('/assessments', [AssessmentController::class, 'getAllAssessments']);
    Route::get('/assessments/{id}', [AssessmentController::class, 'getAssessmentsById']);
    Route::post('/assessments', [AssessmentController::class, 'createAssessment']);
    Route::put('/assessments/{id}', [AssessmentController::class, 'updateAssessment']);
    // Route for countries
    Route::get('/countries', [CountryController::class, 'getAllCountries']);
    Route::get('/countries/{id}', [CountryController::class, 'getCountryById']);
    Route::post('/countries', [CountryController::class, 'createCountry']);
});