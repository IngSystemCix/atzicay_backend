<?php

namespace App\Domain\Services;

use App\Application\Traits\ApiResponse;
use App\Domain\Entities\GameInstances;
use App\Domain\Entities\GameProgress;
use App\Domain\Entities\GameSession;
use App\Domain\Entities\ProgrammingGame;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GameService
{
    use ApiResponse;
    public function createGame(Request $request)
    {
        $uploader = new UploadFileServices();
        DB::beginTransaction();
        try {
            $gameInstance = GameInstances::create([
                'Name' => $request->input('Name'),
                'Description' => $request->input('Description'),
                'ProfessorId' => $request->input('ProfessorId'),
                'Activated' => $request->input('Activated'),
                'Difficulty' => $request->input('Difficulty'),
                'Visibility' => $request->input('Visibility')
            ]);

            foreach ($request->input('settings', []) as $setting) {
                $gameInstance->gameSetting()->create(
                    collect($setting)->only(['ConfigKey', 'ConfigValue'])->toArray()
                );
            }

            $gameInstance->assessments()->create([
                'UserId' => $gameInstance->ProfessorId,
                'Activated' => true,
                'Value' => $request->input('assessment.value'),
                'Comments' => $request->input('assessment.comments'),
                'GameInstanceId' => $gameInstance->Id
            ]);

            $uploader = new UploadFileServices();
            $game_type = $request->input('game_type');

            switch ($game_type) {
                case 'hangman':
                    foreach ($request->input('hangman.words', []) as $wordData) {
                        $gameInstance->hangman()->create([
                            'Word' => $wordData['word'],
                            'Clue' => $wordData['clue'],
                            'Presentation' => $request->input('hangman.presentation'),
                            'GameInstanceId' => $gameInstance->Id
                        ]);
                    }
                    break;

                case 'memory':
                    $mode = $request->input('memory.mode');
                    $memoryItems = $request->input('memory.items', []);
                    $uploaded_files = $uploader->upload_multiple($_FILES['files'], 'memory_game', $gameInstance->Id);

                    foreach ($memoryItems as $index => $item) {
                        $img1 = $uploaded_files[$index * 2]['file'] ?? null;
                        $img2 = $mode === 'II' ? ($uploaded_files[($index * 2) + 1]['file'] ?? null) : null;
                        $desc = $mode === 'ID' ? $item['description_img'] : null;

                        $gameInstance->memoryGame()->create([
                            'Mode' => $mode,
                            'PathImg1' => $img1,
                            'PathImg2' => $img2,
                            'DescriptionImg' => $desc,
                            'GameInstanceId' => $gameInstance->Id
                        ]);
                    }
                    break;

                case 'puzzle':
                    $uploaded = $uploader->upload_multiple($_FILES['files'], 'puzzles', $gameInstance->Id);
                    $img_path = $uploaded[0]['file'] ?? null;

                    $gameInstance->puzzle()->create([
                        'GameInstanceId' => $gameInstance->Id,
                        'PathImg' => $img_path,
                        'Clue' => $request->input('puzzle.clue'),
                        'Rows' => $request->input('puzzle.rows'),
                        'Cols' => $request->input('puzzle.columns'),
                        'AutomaticHelp' => $request->input('puzzle.automatic_help', false),
                    ]);
                    break;

                case 'solve_the_word':
                    $solveTheWord = $gameInstance->solveTheWord()->create([
                        'Rows' => $request->input('solve_the_word.rows'),
                        'Cols' => $request->input('solve_the_word.columns'),
                        'GameInstanceId' => $gameInstance->Id
                    ]);

                    $words = $request->input('solve_the_word.words', []);
                    foreach ($words as $wordData) {
                        $solveTheWord->words()->create([
                            'SolveTheWordId' => $solveTheWord->GameInstanceId,
                            'Word' => $wordData['word'],
                            'Orientation' => $wordData['orientation'],
                        ]);
                    }
                    break;
            }

            DB::commit();
            return $this->successResponse($gameInstance, 2214);

        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Error al crear juego: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->errorResponse(2215);
        }
    }


    public function getGameById(int $id): ?array
    {
        $game = GameInstances::with([
            'professor',
            'assessments',
            'hangman',
            'memoryGame',
            'puzzle',
            'solveTheWord.words', // Incluye palabras si es 'solve the word'
            'gameSetting'
        ])->find($id);

        if (!$game) {
            return null;
        }

        $type = 'Unknown';

        if ($game->hangman()->exists()) {
            $type = 'Hangman';
        } elseif ($game->memoryGame()->exists()) {
            $type = 'Memory';
        } elseif ($game->puzzle()->exists()) {
            $type = 'Puzzle';
        } elseif ($game->solveTheWord()->exists()) {
            $type = 'Solve the Word';
        }

        return [
            'id' => $game->Id,
            'title' => $game->Name,
            'description' => $game->Description,
            'difficulty' => $game->Difficulty,
            'visibility' => $game->Visibility,
            'activated' => $game->Activated,
            'rating' => $game->assessments->avg('Value') ?? 0,
            'assessment' => $game->assessments->map(fn($a) => [
                'value' => $a->Value,
                'comments' => $a->Comments,
            ]),
            'author' => $game->professor
                ? $game->professor->Name . ' ' . $game->professor->LastName
                : 'Unknown',
            'type' => $type,
            'settings' => $game->gameSetting->map(fn($s) => [
                'key' => $s->ConfigKey,
                'value' => $s->ConfigValue,
            ]),
            'game_data' => match ($type) {
                'Hangman' => [
                    'word' => $game->hangman->Word,
                    'clue' => $game->hangman->Clue,
                    'presentation' => $game->hangman->Presentation,
                ],
                'Memory' => [
                    'mode' => $game->memoryGame->Mode,
                    'path_img1' => $game->memoryGame->PathImg1,
                    'path_img2' => $game->memoryGame->PathImg2,
                    'description_img' => $game->memoryGame->DescriptionImg,
                ],
                'Puzzle' => [
                    'pieces' => $game->puzzle->Pieces,
                    'image_url' => $game->puzzle->ImageUrl,
                ],
                'Solve the Word' => [
                    'rows' => $game->solveTheWord->Rows,
                    'columns' => $game->solveTheWord->Columns,
                    'words' => $game->solveTheWord->words->map(fn($w) => [
                        'word' => $w->Word,
                        'orientation' => $w->Orientation,
                    ]),
                ],
                default => null,
            }
        ];
    }

    public function programmingGame(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            // Obtener la instancia de juego
            $gameInstance = GameInstances::findOrFail($id);

            // Actualizar o crear el ProgrammingGame asociado
            $programmingGame = $gameInstance->programmingGame()->first();

            if (!$programmingGame) {
                // Validación: asegurar que ProgrammerId esté presente
                if (!$request->filled('ProgrammerId')) {
                    throw new \Exception("El campo 'ProgrammerId' es obligatorio al crear ProgrammingGame.");
                }

                $programmingGame = $gameInstance->programmingGame()->create([
                    'ProgrammerId' => $request->input('ProgrammerId'),
                    'Name' => $request->input('ProgrammingGameName'),
                    'Activated' => $request->input('Activated', false),
                    'StartTime' => $request->input('StartTime'),
                    'EndTime' => $request->input('EndTime'),
                    'Attempts' => $request->input('Attempts'),
                    'MaximumTime' => $request->input('MaximumTime')
                ]);
            } else {
                // Campos que pueden actualizarse en ProgrammingGame
                $programmingFields = ['ProgrammerId', 'Name', 'Activated', 'StartTime', 'EndTime', 'Attempts', 'MaximumTime'];

                foreach ($programmingFields as $field) {
                    if ($request->has($field)) {
                        $programmingGame->$field = $request->input($field);
                    }
                }

                $programmingGame->save();
            }

            DB::commit();

            return $this->successResponse($gameInstance->load('programmingGame'), 2202);

        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Error al actualizar ProgrammingGame: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->errorResponse(2203);
        }
    }

    public function filterProgrammingGames(Request $request, $professorId)
    {
        $startDate = $request->query('start');
        $endDate = $request->query('end');

        $query = ProgrammingGame::query();

        if ($startDate && $endDate) {
            $query->whereBetween('StartTime', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('StartTime', $startDate);
        } elseif ($endDate) {
            $query->whereDate('EndTime', $endDate);
        }

        // Filtra por profesor usando la relación correcta
        $query->whereHas('gameInstances', function ($q) use ($professorId) {
            $q->where('ProfessorId', $professorId);
        });

        // Eager load de relaciones anidadas desde gameInstances
        $results = $query->with([
            'gameInstances.hangman',
            'gameInstances.solveTheWord',
            'gameInstances.memoryGame',
            'gameInstances.puzzle'
        ])->get();

        // Mapeo para devolver la información incluyendo Difficulty
        $results = $results->map(function ($pg) {
            // Obtiene la primera instancia relacionada de GameInstance
            $gameInstance = $pg->gameInstances->first(); // Usamos first() porque es hasMany

            $tipoJuego = null;
            $difficulty = null;

            if ($gameInstance) {
                $difficulty = $gameInstance->Difficulty; // Incluye la dificultad si existe

                if ($gameInstance->hangman) {
                    $tipoJuego = 'Hangman';
                } elseif ($gameInstance->solveTheWord) {
                    $tipoJuego = 'SolveTheWord';
                } elseif ($gameInstance->memoryGame) {
                    $tipoJuego = 'MemoryGame';
                } elseif ($gameInstance->puzzle) {
                    $tipoJuego = 'Puzzle';
                }
            }

            return [
                'Name' => $pg->Name,
                'Activated' => $pg->Activated,
                'StartTime' => $pg->StartTime,
                'EndTime' => $pg->EndTime,
                'Attempts' => $pg->Attempts,
                'MaximumTime' => $pg->MaximumTime,
                'Difficulty' => $difficulty, // Devuelve la dificultad
                'TipoDeJuego' => $tipoJuego,
            ];
        });

        return $this->successResponse($results, 2204);
    }

    public function updateGame(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $gameInstance = GameInstances::findOrFail($id);

            $gameInstance->update([
                'Name' => $request->input('Name'),
                'Description' => $request->input('Description'),
                'ProfessorId' => $request->input('ProfessorId'),
                'Activated' => $request->input('Activated'),
                'Difficulty' => $request->input('Difficulty'),
                'Visibility' => $request->input('Visibility')
            ]);

            // Solo actualizar settings existentes
            foreach ($request->input('settings', []) as $settingInput) {
                $configKey = $settingInput['ConfigKey'];
                $configValue = $settingInput['ConfigValue'];

                $existingSetting = $gameInstance->gameSetting()->where('ConfigKey', $configKey)->first();
                if ($existingSetting) {
                    $existingSetting->update(['ConfigValue' => $configValue]);
                }
                // Si deseas permitir agregar nuevas configuraciones, descomenta esta parte:
                /*
                else {
                    $gameInstance->gameSetting()->create([
                        'ConfigKey' => $configKey,
                        'ConfigValue' => $configValue
                    ]);
                }
                */
            }

            // Actualizar o crear assessment
            $assessment = $gameInstance->assessments()->first();
            if ($assessment) {
                $assessment->update([
                    'UserId' => $gameInstance->ProfessorId,
                    'Activated' => true,
                    'Value' => $request->input('assessment.value'),
                    'Comments' => $request->input('assessment.comments'),
                ]);
            } else {
                $gameInstance->assessments()->create([
                    'UserId' => $gameInstance->ProfessorId,
                    'Activated' => true,
                    'Value' => $request->input('assessment.value'),
                    'Comments' => $request->input('assessment.comments'),
                    'GameInstanceId' => $gameInstance->Id
                ]);
            }

            // Eliminar datos previos del tipo de juego antes de recrear
            $gameInstance->hangman()->delete();
            $gameInstance->memoryGame()->delete();
            $gameInstance->puzzle()->delete();
            $gameInstance->solveTheWord()->delete();

            // Crear contenido de juego según tipo
            switch ($request->input('game_type')) {
                case 'hangman':
                    foreach ($request->input('hangman.words', []) as $wordData) {
                        $gameInstance->hangman()->create([
                            'Word' => $wordData['word'],
                            'Clue' => $wordData['clue'],
                            'Presentation' => $request->input('hangman.presentation'),
                            'GameInstanceId' => $gameInstance->Id
                        ]);
                    }
                    break;

                case 'memory':
                    $mode = $request->input('memory.mode');
                    foreach ($request->input('memory.items', []) as $item) {
                        $gameInstance->memoryGame()->create([
                            'Mode' => $mode,
                            'PathImg1' => $item['path_img1'],
                            'PathImg2' => $mode === 'II' ? $item['path_img2'] : null,
                            'DescriptionImg' => $mode === 'ID' ? $item['description_img'] : null,
                            'GameInstanceId' => $gameInstance->Id
                        ]);
                    }
                    break;

                case 'puzzle':
                    $gameInstance->puzzle()->create([
                        'GameInstanceId' => $gameInstance->Id,
                        'PathImg' => $request->input('puzzle.image_url'),
                        'Clue' => $request->input('puzzle.clue'),
                        'Rows' => $request->input('puzzle.rows'),
                        'Cols' => $request->input('puzzle.columns'),
                        'AutomaticHelp' => $request->input('puzzle.automatic_help', false),
                    ]);
                    break;

                case 'solve_the_word':
                    $solveTheWord = $gameInstance->solveTheWord()->create([
                        'Rows' => $request->input('solve_the_word.rows'),
                        'Cols' => $request->input('solve_the_word.columns'),
                        'GameInstanceId' => $gameInstance->Id
                    ]);

                    foreach ($request->input('solve_the_word.words', []) as $wordData) {
                        $solveTheWord->words()->create([
                            'SolveTheWordId' => $solveTheWord->GameInstanceId,
                            'Word' => $wordData['word'],
                            'Orientation' => $wordData['orientation'],
                        ]);
                    }
                    break;
            }

            DB::commit();
            return $this->successResponse($gameInstance->load(['gameSetting', 'assessments']), 2216);

        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Error al actualizar juego: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return $this->errorResponse(2217);
        }
    }

    public function createGameSessionWithProgress(Request $request)
    {
        DB::beginTransaction();

        try {
            // Crear la sesión de juego
            $gameSession = GameSession::create([
                'ProgrammingGameId' => $request->input('ProgrammingGameId'),
                'StudentId' => $request->input('StudentId'),
                'Duration' => $request->input('Duration'),
                'Won' => $request->input('Won'),
                'DateGame' => $request->input('DateGame'),
            ]);

            // Validar y codificar el campo Progress como JSON
            $progressData = $request->input('Progress');
            if (!is_array($progressData) && !is_object($progressData)) {
                throw new \Exception('El campo Progress debe ser un objeto o arreglo válido');
            }

            $gameProgress = GameProgress::create([
                'GameSessionId' => $gameSession->Id,
                'Progress' => json_encode($progressData),
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Game session and progress created successfully',
                'gameSession' => $gameSession,
                'gameProgress' => $gameProgress
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            logger()->error('Error creating game session with progress: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['error' => 'Error creating game session with progress'], 500);
        }
    }

}