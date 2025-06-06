<?php
use App\Infrastructure\Http\Controllers\AssessmentController;
use App\Infrastructure\Http\Controllers\AuthController;
use App\Infrastructure\Http\Controllers\CountryController;
use App\Infrastructure\Http\Controllers\GameInstancesController;
use App\Infrastructure\Http\Controllers\GameProgressController;
use App\Infrastructure\Http\Controllers\GameSessionsController;
use App\Infrastructure\Http\Controllers\GameSettingController;
use App\Infrastructure\Http\Controllers\HangmanController;
use App\Infrastructure\Http\Controllers\MemoryGameController;
use App\Infrastructure\Http\Controllers\ProgrammingGameController;
use App\Infrastructure\Http\Controllers\PuzzleController;
use App\Infrastructure\Http\Controllers\SolveTheWordController;
use App\Infrastructure\Http\Controllers\UserController;
use App\Infrastructure\Http\Controllers\WordsController;

Route::prefix('atzicay/v1')->group(function () {
    Route::get('/game-instances/programming/filter/{id}', [GameInstancesController::class, 'filterProgrammingGames']);
    // Route for authentication
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/refresh', [AuthController::class, 'refresh']);
});

Route::prefix('atzicay/v1')->middleware(['atzicay.auth'])->group(function () {
    // Route for authentication
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    // Route for countries
    Route::get('/countries', [CountryController::class, 'getAllCountries']);
    Route::get('/countries/{id}', [CountryController::class, 'getCountryById']);
    Route::post('/countries', [CountryController::class, 'createCountry']);
    // Route for users
    Route::get('/users', [UserController::class, 'getAllUsers']);
    Route::get('/users/{id}', [UserController::class, 'getUserById']);
    Route::post('/users', [UserController::class, 'createUser']);
    Route::post('/users/find', [UserController::class, 'findUserByEmail']);
    Route::put('/users/{id}', [UserController::class, 'updateUser']);
    Route::delete('/users/{id}', [UserController::class, 'deleteUser']);
    // Route for game instances
    
    Route::get('/game-instances/personal/count/{idProfessor}', [GameInstancesController::class, 'countGameTypesByProfessor']);
    Route::get('/game-instances/search', [GameInstancesController::class, 'searchGameInstances']);
    Route::get('/game-instances/personal/{id}', [GameInstancesController::class, 'getAllGameInstances']);
    Route::get('/game-instances/all/{limit?}', [GameInstancesController::class, 'getAllGame']);
    Route::get('/game-instances/{id}', [GameInstancesController::class, 'getGameInstanceById']);
    Route::post('/game-instances', [GameInstancesController::class, 'createGameInstance']);
    Route::put('/game-instances/{id}', [GameInstancesController::class, 'updateGameInstance']);
    Route::delete('/game-instances/{id}', [GameInstancesController::class, 'deleteGameInstance']);
    Route::get('/game-instances/configuration/{id}', [GameInstancesController::class, 'getConfigurations']);
    Route::post('/game-instances/game', [GameInstancesController::class, 'createGame']);
    Route::put('/game-instances/game/{id}', [GameInstancesController::class, 'editGame']);
    Route::post('/game-instances/programming/{id}', [GameInstancesController::class, 'programmingGame']);
    Route::post('/game-instances/progress', [GameInstancesController::class, 'progressGame']);
    // Route for programming games
    Route::get('/programming-games', [ProgrammingGameController::class, 'getAllProgrammingGames']);
    Route::get('/programming-games/{id}', [ProgrammingGameController::class, 'getProgrammingGameById']);
    Route::post('/programming-games', [ProgrammingGameController::class, 'createProgrammingGame']);
    Route::put('/programming-games/{id}', [ProgrammingGameController::class, 'updateProgrammingGame']);
    Route::delete('/programming-games/{id}', [ProgrammingGameController::class, 'deleteProgrammingGame']);
    // Routes for assessments
    Route::get('/assessments', [AssessmentController::class, 'getAllAssessments']);
    Route::get('/assessments/{id}', [AssessmentController::class, 'getAssessmentsById']);
    Route::post('/assessments', [AssessmentController::class, 'createAssessment']);
    Route::put('/assessments/{id}', [AssessmentController::class, 'updateAssessment']);
    Route::delete('/assessments/{id}', [AssessmentController::class, 'deleteAssessment']);
    // Route for game settings
    Route::get('/game-settings/{id}', [GameSettingController::class, 'getGameSettingById']);
    Route::post('/game-settings', [GameSettingController::class, 'createGameSetting']);
    Route::put('/game-settings/{id}', [GameSettingController::class, 'updateGameSetting']);
    // Route for hangman game
    Route::get('/hangman/{id}', [HangmanController::class, 'getHangmanById']);
    Route::post('/hangman', [HangmanController::class, 'createHangman']);
    Route::put('/hangman/{id}', [HangmanController::class, 'updateHangman']);
    // Route for solve the word game
    Route::get('/solve-the-word/{id}', [SolveTheWordController::class, 'getSolveTheWordById']);
    Route::post('/solve-the-word', [SolveTheWordController::class, 'createSolveTheWord']);
    Route::put('/solve-the-word/{id}', [SolveTheWordController::class, 'updateSolveTheWord']);
    // Route for memory game
    Route::get('/memory-game/{id}', [MemoryGameController::class, 'getMemoryGameById']);
    Route::post('/memory-game', [MemoryGameController::class, 'createMemoryGame']);
    Route::put('/memory-game/{id}', [MemoryGameController::class, 'updateMemoryGame']);
    // Route for puzzles
    Route::get('/puzzles/{id}', [PuzzleController::class, 'getPuzzleById']);
    Route::post('/puzzles', [PuzzleController::class, 'createPuzzle']);
    Route::put('/puzzles/{id}', [PuzzleController::class, 'updatePuzzle']);
    // Route for game sessions
    Route::get('/game-sessions/{id}', [GameSessionsController::class, 'getGameSessionById']);
    Route::post('/game-sessions', [GameSessionsController::class, 'createGameSession']);
    Route::put('/game-sessions/{id}', [GameSessionsController::class, 'updateGameSession']);
    // Route for words
    Route::get('/words/{id}', [WordsController::class, 'getWordById']);
    Route::post('/words', [WordsController::class, 'createWord']);
    Route::put('/words/{id}', [WordsController::class, 'updateWord']);
    // Route for game progress
    Route::get('/game-progress/{id}', [GameProgressController::class, 'getGameProgressById']);
    Route::post('/game-progress', [GameProgressController::class, 'createGameProgress']);
    Route::put('/game-progress/{id}', [GameProgressController::class, 'updateGameProgress']);
});
