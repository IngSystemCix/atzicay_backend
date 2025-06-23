<?php

use App\Http\Controllers\ProgrammingController;
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
        Route::get('/game/report/{gameInstanceId}', [GameController::class, 'reportGame']);
        Route::get('/game/settings/{gameInstanceId}', [GameController::class, 'getSettingsGame']);

        // Programming Routes
        Route::get('/my-programming-games/{userId}', [ProgrammingController::class, 'myProgrammingGames']);
        Route::put('/disable-programming-game/{gameInstanceId}', [ProgrammingController::class, 'disableProgrammingGame']);
        Route::post('/programming-game/create/{gameInstanceId}/{userId}', [ProgrammingController::class, 'createProgrammingGame']);

        // User Routes
        Route::get('/user/profile/{userId}', [UserController::class, 'getUserProfile']);
        Route::put('/user/update/{userId}', [UserController::class, 'updateUserProfile']);
        Route::post('/user/id-by-email', [UserController::class, 'getIdByEmail']);

        // Country Routes
        Route::get('/country/all', [\App\Http\Controllers\CountryController::class, 'getAllCountries']);
    });
});