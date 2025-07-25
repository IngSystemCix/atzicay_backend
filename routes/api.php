<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\ProgrammingController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::prefix('v1/atzicay')->group(function () {
    // Public Auth Routes
    Route::post('/auth/generate-token', [\App\Http\Controllers\AuthController::class, 'generateToken']);
    Route::post('/auth/refresh-token', [\App\Http\Controllers\AuthController::class, 'refreshToken']);
    
    // Protected Routes
    Route::middleware(['auth.jwt'])->group(function () {
        // Game Routes
        Route::get('/game/filter', [GameController::class, 'gameAllFilter']);
        Route::get('/game/amount-by-type/{userId}', [GameController::class, 'amountByGameType']);
        Route::get('/my-games/{userId}', [GameController::class, 'myGames']);
        Route::put('/my-game/update-status/{gameInstanceId}', [GameController::class, 'updateStatusGameInstance']);
        Route::put('/my-game/update/{gameInstanceId}', [GameController::class, 'updateGameInstance']);
        Route::post('/my-game/create/{userId}', [GameController::class, 'createGame']);
        Route::get('/game/ratings/{gameInstanceId}', [GameController::class, 'ratingsGame']);
        Route::get('/game/report/{gameInstanceId}', [GameController::class, 'reportGame']);
        Route::get('/game/settings/{gameInstanceId}', [GameController::class, 'getSettingsGame']);
        Route::put('/game/{gameInstanceId}/privacy/{privacity}', [GameController::class, 'privacityGame']);
        Route::get('/assessments/average/{userId}', [GameController::class, 'averageAssessmentByUser']);

        // Programming Routes
        Route::get('/my-programming-games/{userId}', [ProgrammingController::class, 'myProgrammingGames']);
        Route::put('/programming-game/update-status/{gameInstanceId}', [ProgrammingController::class, 'setProgrammingGameStatus']);
        Route::post('/programming-game/create/{gameInstanceId}/{userId}', [ProgrammingController::class, 'createProgrammingGame']);

        // User Routes
        Route::get('/user/profile/{userId}', [UserController::class, 'getUserProfile']);
        Route::put('/user/update/{userId}', [UserController::class, 'updateUserProfile']);
        Route::post('/user/id-by-email', [UserController::class, 'getIdByEmail']);

        // Country Routes
        Route::get('/country/all', [CountryController::class, 'getAllCountries']);

        // Rating Routes
        Route::post('/rate-game/{gameInstanceId}/{userId}', [RatingController::class, 'valueRating']);

        // game sessions
        Route::post('/game-sessions/{programmingGameId}/{studentId}', [GameController::class, 'storeGameSession']);
        Route::put('/game-sessions/{gameInstanceId}/{userId}', [GameController::class, 'updateSessionByInstanceAndUser']);

        // game progress
        Route::get('/game-progress/{gameInstanceId}/{userId}', [GameController::class, 'getGameProgress']);
    });
});