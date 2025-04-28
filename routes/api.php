<?php
use App\Infrastructure\Http\Controllers\AssessmentController;
use App\Infrastructure\Http\Controllers\HangmanController;
use App\Infrastructure\Http\Controllers\MemoryGameController;
use App\Infrastructure\Http\Controllers\PuzzleController;

Route::prefix('atzicay/v1')->group(function () {
    // Routes for assessments
    Route::get('/assessments', [AssessmentController::class, 'getAllAssessments']);
    Route::get('/assessments/{id}', [AssessmentController::class, 'getAssessmentsById']);
    Route::post('/assessments', [AssessmentController::class, 'createAssessment']);
    Route::post('/hangman', [HangmanController::class,'createHangman']);
    Route::post('/hangman', [HangmanController::class,'getAllHangman']);
    Route::post('/hangman/{id}', [HangmanController::class,'getHangmanById']);
    Route::post('/hangman', [HangmanController::class,'deleteHangman']);
    Route::post('/hangman', [HangmanController::class,'updateHangman']);
    Route::post('/memoryGame',[MemoryGameController::class,'createMemoryGame']);
    Route::post('/memoryGame', [MemoryGameController::class,'getAllMemoryGame']);
    Route::post('/memoryGame/{id}', [MemoryGameController::class,'getMemoryGameById']);
    Route::post('/memoryGame', [MemoryGameController::class,'updateMemoryGame']);
    Route::post('/memoryGame', [MemoryGameController::class,'deleteMemoryGame']);
    Route::post('/puzzle',[PuzzleController::class,'createPuzzle']);
    Route::post('/puzzle', [PuzzleController::class,'getAllPuzzle']);
    Route::post('/puzzle', [PuzzleController::class,'getPuzzleById']);
    Route::post('/puzzle', [PuzzleController::class,'updatePuzzle']);
    Route::post('/puzzle', [PuzzleController::class,'deletePuzzle']);
});