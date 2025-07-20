<?php

namespace App\Services;

use App\Models\Assessment;
use App\Models\GameInstance;
use App\Models\GameProgress;
use App\Models\GameSessions;
use App\Models\GameSettings;
use App\Models\Hangman;
use App\Models\MemoryGame;
use App\Models\Puzzle;
use App\Models\SolveTheWord;
use App\Models\User;
use App\Models\Word;
use App\Models\ProgrammingGame;
use Illuminate\Support\Facades\DB;
use App\Utils\StorageUtility;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class GameService
{
    public function gameAllFilter(?string $search, ?string $gameType, int $limit = 6, int $offset = 0): array
    {
        // Consulta para obtener el total sin limit/offset
        $totalQuery = GameInstance::query()
            ->join('users', 'users.Id', '=', 'gameinstances.ProfessorId')
            ->leftJoin('hangman', 'hangman.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('memorygame', 'memorygame.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('puzzle', 'puzzle.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('solvetheword', 'solvetheword.GameInstanceId', '=', 'gameinstances.Id')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(users.Name, ' ', users.LastName)"), 'like', "%$search%")
                        ->orWhere('gameinstances.Name', 'like', "%$search%");
                });
            })
            ->when($gameType && $gameType !== 'all', function ($query) use ($gameType) {
                $query->where(DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END"), '=', $gameType);
            });

        $total = $totalQuery->count(DB::raw('DISTINCT gameinstances.Id'));

        // Consulta paginada
        $data = GameInstance::query()
            ->select([
                'gameinstances.Name AS name',
                'gameinstances.Difficulty AS difficulty',
                DB::raw("CONCAT(users.Name, ' ', users.LastName) AS author"),
                DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END AS type_game"),
                DB::raw("COALESCE(AVG(assessment.Value), 0) AS rating"),
                'gameinstances.Id AS game_instance_id',
                'users.Id AS author_id',
            ])
            ->join('users', 'users.Id', '=', 'gameinstances.ProfessorId')
            ->leftJoin('hangman', 'hangman.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('memorygame', 'memorygame.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('puzzle', 'puzzle.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('solvetheword', 'solvetheword.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('assessment', 'assessment.GameInstanceId', '=', 'gameinstances.Id')
            ->where('gameinstances.Visibility', 'P') // Solo juegos públicos
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where(DB::raw("CONCAT(users.Name, ' ', users.LastName)"), 'like', "%$search%")
                        ->orWhere('gameinstances.Name', 'like', "%$search%");
                });
            })
            ->when($gameType && $gameType !== 'all', function ($query) use ($gameType) {
                $query->where(DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END"), '=', $gameType);
            })
            ->groupBy(
                'gameinstances.Id',
                'gameinstances.Name',
                'gameinstances.Difficulty',
                'users.Name',
                'users.LastName',
                'users.Id',
                'hangman.GameInstanceId',
                'memorygame.GameInstanceId',
                'puzzle.GameInstanceId',
                'solvetheword.GameInstanceId'
            )
            ->orderBy('rating', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->toArray();

        return [
            'total' => $total,
            'data' => $data,
        ];
    }

    public function amountByGameType(int $userId): array
    {
        return GameInstance::query()
            ->select([
                DB::raw('COUNT(DISTINCT hangman.GameInstanceId) AS hangman_count'),
                DB::raw('COUNT(DISTINCT memorygame.GameInstanceId) AS memorygame_count'),
                DB::raw('COUNT(DISTINCT puzzle.GameInstanceId) AS puzzle_count'),
                DB::raw('COUNT(DISTINCT solvetheword.GameInstanceId) AS solvetheword_count'),
            ])
            ->leftJoin('hangman', 'hangman.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('memorygame', 'memorygame.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('puzzle', 'puzzle.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('solvetheword', 'solvetheword.GameInstanceId', '=', 'gameinstances.Id')
            ->where('gameinstances.ProfessorId', $userId)
            ->first() // solo necesitas un registro con estos counts
            ->toArray();
    }

    public function myGames(int $userId, string $gameType, int $limit = 6, int $offset = 0): array
    {
        // Consulta para obtener el total
        $totalQuery = GameInstance::query()
            ->join('users', 'users.Id', '=', 'gameinstances.ProfessorId')
            ->leftJoin('hangman', 'hangman.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('memorygame', 'memorygame.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('puzzle', 'puzzle.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('solvetheword', 'solvetheword.GameInstanceId', '=', 'gameinstances.Id')
            ->where('gameinstances.ProfessorId', $userId)
            ->when($gameType !== 'all', function ($query) use ($gameType) {
                $query->where(DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END"), '=', $gameType);
            });

        // Contar total
        $total = $totalQuery->count(DB::raw('DISTINCT gameinstances.Id'));

        // Consulta para traer datos paginados
        $data = GameInstance::query()
            ->select([
                'gameinstances.Name AS name',
                'gameinstances.Difficulty AS difficulty',
                'gameinstances.Activated AS activated',
                'gameinstances.Visibility AS visibility',
                DB::raw("CONCAT(users.Name, ' ', users.LastName) AS author"),
                DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END AS type_game"),
                DB::raw("COALESCE(AVG(assessment.Value), 0) AS rating"),
                'gameinstances.Id AS game_instance_id',
                'users.Id AS author_id',
            ])
            ->join('users', 'users.Id', '=', 'gameinstances.ProfessorId')
            ->leftJoin('hangman', 'hangman.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('memorygame', 'memorygame.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('puzzle', 'puzzle.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('solvetheword', 'solvetheword.GameInstanceId', '=', 'gameinstances.Id')
            ->leftJoin('assessment', 'assessment.GameInstanceId', '=', 'gameinstances.Id')
            ->where('gameinstances.ProfessorId', $userId)
            ->when($gameType !== 'all', function ($query) use ($gameType) {
                $query->where(DB::raw("CASE
                WHEN hangman.GameInstanceId IS NOT NULL THEN 'hangman'
                WHEN memorygame.GameInstanceId IS NOT NULL THEN 'memory'
                WHEN puzzle.GameInstanceId IS NOT NULL THEN 'puzzle'
                WHEN solvetheword.GameInstanceId IS NOT NULL THEN 'solve_the_word'
                ELSE 'unknown'
            END"), '=', $gameType);
            })
            ->groupBy(
                'gameinstances.Id',
                'gameinstances.Name',
                'gameinstances.Difficulty',
                'gameinstances.Activated',
                'gameinstances.Visibility',
                'users.Name',
                'users.LastName',
                'users.Id',
                'hangman.GameInstanceId',
                'memorygame.GameInstanceId',
                'puzzle.GameInstanceId',
                'solvetheword.GameInstanceId'
            )
            ->orderBy('rating', 'desc')
            ->limit($limit)
            ->offset($offset)
            ->get()
            ->toArray();

        return [
            'total' => $total,
            'data' => $data,
        ];
    }

    public function updateStatus(int $gameInstanceId, bool $status): string
    {
        $gameInstance = GameInstance::find($gameInstanceId);
        if (!$gameInstance) {
            return 'Game instance not found';
        }

        $gameInstance->Activated = $status;
        $gameInstance->save();

        return 'Game instance status updated successfully';
    }

    public function updateByGameType(int $gameInstanceId, string $gameType, array $data): string
    {
        $gameInstanceId = GameInstance::find($gameInstanceId);
        if (!$gameInstanceId) {
            return 'Game instance not found';
        }

        switch (strtolower($gameType)) {
            case 'hangman':
                $hangman = Hangman::where('GameInstanceId', $gameInstanceId)->first();
                if (!$hangman) {
                    return 'Hangman game not found for this instance';
                }
                $hangman->update([
                    'Word' => $data['Word'] ?? $hangman->Word,
                    'Clue' => $data['Clue'] ?? $hangman->Clue,
                    'Presentation' => $data['Presentation'] ?? $hangman->Presentation,
                ]);
                return 'Hangman game updated successfully';

            case 'memory':
                $memoryGame = MemoryGame::where('GameInstanceId', $gameInstanceId)->first();
                if (!$memoryGame) {
                    return 'Memory game not found for this instance';
                }

                // PathImage1
                if (!empty($data['PathImage1'])) {
                    $upload1 = StorageUtility::uploadImage(
                        $data['PathImage1'],
                        env('PATH_STORAGE', '') . '/memory', // RUTA DE DESTINO ESPECÍFICA PARA MEMORY
                        'memory_'
                    );

                    if (!empty($upload1['success'][0])) {
                        $data['PathImage1'] = $upload1['success'][0];
                    } else {
                        return 'Error uploading PathImage1: ' . implode(', ', $upload1['errors']);
                    }
                }

                // PathImage2 (modo II)
                if (isset($data['Mode']) && $data['Mode'] === 'II' && !empty($data['PathImage2'])) {
                    $upload2 = StorageUtility::uploadImage(
                        $data['PathImage2'],
                        env('PATH_STORAGE', '') . '/memory',
                        'memory_'
                    );

                    if (!empty($upload2['success'][0])) {
                        $data['PathImage2'] = $upload2['success'][0];
                    } else {
                        return 'Error uploading PathImage2: ' . implode(', ', $upload2['errors']);
                    }
                }

                // Actualización según modo
                switch ($data['Mode'] ?? $memoryGame->Mode) {
                    case 'II':
                        $memoryGame->update([
                            'Mode' => $data['Mode'] ?? $memoryGame->Mode,
                            'PathImage1' => $data['PathImage1'] ?? $memoryGame->PathImage1,
                            'PathImage2' => $data['PathImage2'] ?? $memoryGame->PathImage2,
                        ]);
                        break;

                    case 'ID':
                        $memoryGame->update([
                            'Mode' => $data['Mode'] ?? $memoryGame->Mode,
                            'PathImage1' => $data['PathImage1'] ?? $memoryGame->PathImage1,
                            'Description' => $data['Description'] ?? $memoryGame->Description,
                        ]);
                        break;

                    default:
                        return 'Invalid mode for Memory game';
                }

                return 'Memory game updated successfully';


            case 'puzzle':
                $puzzle = Puzzle::where('GameInstanceId', $gameInstanceId)->first();
                if (!$puzzle) {
                    return 'Puzzle game not found for this instance';
                }

                if (!empty($data['PathImg'])) {
                    $upload = StorageUtility::uploadImage(
                        $data['PathImg'],
                        env('PATH_STORAGE', '') . '/puzzle', // RUTA DE DESTINO ESPECÍFICA PARA PUZZLE
                        'puzzle_'
                    );

                    if (!empty($upload['success'][0])) {
                        // Si deseas almacenar la ruta absoluta en BD (no recomendado) usa $upload['success'][0]
                        // Si prefieres relativa, cambia esto según la lógica de tu app:
                        $data['PathImg'] = $upload['success'][0]; // ruta completa
                    } else {
                        return 'Error uploading PathImg: ' . implode(', ', $upload['errors']);
                    }
                }

                $puzzle->update([
                    'PathImg' => $data['PathImg'] ?? $puzzle->PathImg,
                    'Clue' => $data['Clue'] ?? $puzzle->Clue,
                    'Rows' => $data['Rows'] ?? $puzzle->Rows,
                    'Cols' => $data['Cols'] ?? $puzzle->Cols,
                    'AutomaticHelp' => $data['AutomaticHelp'] ?? $puzzle->AutomaticHelp,
                ]);

                return 'Puzzle game updated successfully';
            case 'solve_the_word':
                $solveTheWord = SolveTheWord::where('GameInstanceId', $gameInstanceId)->first();
                if (!$solveTheWord) {
                    return 'Solve the word game not found for this instance';
                }
                $solveTheWord->update([
                    'Rows' => $data['Rows'] ?? $solveTheWord->Rows,
                    'Cols' => $data['Cols'] ?? $solveTheWord->Cols,
                ]);
                if (!empty($data['Words']) && is_array($data['Words'])) {
                    foreach ($data['Words'] as $wordData) {
                        if (isset($wordData['Id'])) {
                            // Actualiza palabra existente
                            $word = Word::where('SolveTheWordId', $solveTheWord->Id)
                                ->where('Id', $wordData['Id'])
                                ->first();
                            if ($word) {
                                $word->update([
                                    'Word' => $wordData['Word'] ?? $word->Word,
                                    'Orientation' => $wordData['Orientation'] ?? $word->Orientation,
                                ]);
                            }
                        } else {
                            // Crea una nueva palabra si no existe ID
                            Word::create([
                                'SolveTheWordId' => $solveTheWord->Id,
                                'Word' => $wordData['Word'] ?? '',
                                'Orientation' => $wordData['Orientation'] ?? 'HR', // valor por defecto si no viene
                            ]);
                        }
                    }
                }
                return 'Solve the word game updated successfully';
            default:
                return 'Invalid game type';
        }
    }

    public function createByGameType(int $professorId, string $gameType, array $data): string
    {
        Log::info('[GameService][createByGameType] INICIO', ['professorId' => $professorId, 'gameType' => $gameType, 'data' => $data]);
        // Crear instancia base del juego
        try {
            $gameInstance = GameInstance::create([
                'Name' => $data['Name'] ?? 'New Game Instance',
                'Description' => $data['Description'] ?? '',
                'ProfessorId' => $professorId,
                'Activated' => $data['Activated'] ?? true,
                'Difficulty' => $data['Difficulty'] ?? 'E',
                'Visibility' => $data['Visibility'] ?? 'P',
            ]);
        } catch (\Exception $e) {
            Log::error('[GameService][createByGameType] Error creando GameInstance', ['error' => $e->getMessage()]);
            return 'Error creating GameInstance: ' . $e->getMessage();
        }
        $gameInstanceId = $gameInstance->Id;
        Log::info('[GameService][createByGameType] GameInstance creado', ['gameInstanceId' => $gameInstanceId]);

        $gameTypeLower = strtolower($gameType);
        Log::info('[GameService][createByGameType] Ejecutando switch con gameType', ['gameType' => $gameType, 'gameTypeLower' => $gameTypeLower]);

        switch ($gameTypeLower) {
            case 'hangman':
                if (!empty($data['Words']) && is_array($data['Words'])) {
                    foreach ($data['Words'] as $wordData) {
                        Hangman::create([
                            'GameInstanceId' => $gameInstanceId,
                            'Word' => $wordData['Word'] ?? '',
                            'Clue' => $wordData['Clue'] ?? '',
                            'Presentation' => $wordData['Presentation'] ?? '',
                        ]);
                    }
                } else {
                    // Soporte legacy si envían solo un Word/Clue
                    Hangman::create([
                        'GameInstanceId' => $gameInstanceId,
                        'Word' => $data['Word'] ?? '',
                        'Clue' => $data['Clue'] ?? '',
                        'Presentation' => $data['Presentation'] ?? '',
                    ]);
                }

                // Guardar configuraciones del juego (Settings)
                if (!empty($data['Settings']) && is_array($data['Settings'])) {
                    foreach ($data['Settings'] as $setting) {
                        if (!empty($setting['ConfigKey']) && isset($setting['ConfigValue'])) {
                            try {
                                GameSettings::create([
                                    'GameInstanceId' => $gameInstanceId,
                                    'ConfigKey' => $setting['ConfigKey'],
                                    'ConfigValue' => $setting['ConfigValue'],
                                ]);
                                Log::info('[GameService][createByGameType] Setting guardado para Hangman', [
                                    'gameInstanceId' => $gameInstanceId,
                                    'ConfigKey' => $setting['ConfigKey'],
                                    'ConfigValue' => $setting['ConfigValue']
                                ]);
                            } catch (\Exception $e) {
                                Log::error('[GameService][createByGameType] Error guardando Setting para Hangman', [
                                    'error' => $e->getMessage(),
                                    'setting' => $setting
                                ]);
                            }
                        }
                    }
                } else {
                    Log::warning('[GameService][createByGameType] Settings faltantes para Hangman game', ['gameInstanceId' => $gameInstanceId]);
                }

                return 'Hangman game created successfully';

            case 'memory':
                if (empty($data['Mode']) || !in_array($data['Mode'], ['II', 'ID'])) {
                    return 'Invalid or missing Mode for Memory game. Must be II or ID';
                }

                if (empty($data['Pairs']) || !is_array($data['Pairs'])) {
                    return 'For Memory game, an array of image pairs or items is required';
                }

                // Directorio destino para imágenes de memory
                $destino = rtrim(env('PATH_STORAGE'), '/\\') . DIRECTORY_SEPARATOR . 'memory';

                foreach ($data['Pairs'] as $index => $pair) {
                    try {
                        if ($data['Mode'] === 'II') {
                            if (empty($pair['PathImg1']) || empty($pair['PathImg2'])) {
                                Log::warning('[GameService][createByGameType] Par inválido modo II', ['index' => $index, 'pair' => $pair]);
                                continue;
                            }

                            // Procesar PathImg1
                            $upload1 = StorageUtility::uploadImage(
                                $pair['PathImg1'],
                                $destino,
                                null, // Generar nombre automáticamente
                                ['jpg', 'jpeg', 'png'],
                                'memory_'
                            );

                            if (empty($upload1['success'][0])) {
                                Log::error('[GameService][createByGameType] Error subiendo PathImg1', ['errores' => $upload1['errors']]);
                                continue;
                            }

                            // Procesar PathImg2
                            $upload2 = StorageUtility::uploadImage(
                                $pair['PathImg2'],
                                $destino,
                                null, // Generar nombre automáticamente
                                ['jpg', 'jpeg', 'png'],
                                'memory_'
                            );

                            if (empty($upload2['success'][0])) {
                                Log::error('[GameService][createByGameType] Error subiendo PathImg2', ['errores' => $upload2['errors']]);
                                continue;
                            }

                            MemoryGame::create([
                                'GameInstanceId' => $gameInstanceId,
                                'Mode' => 'II',
                                'PathImg1' => $upload1['success'][0], // ruta del archivo guardado
                                'PathImg2' => $upload2['success'][0], // ruta del archivo guardado
                                'DescriptionImg' => null, // No aplica en modo II
                            ]);

                        } elseif ($data['Mode'] === 'ID') {
                            if (empty($pair['PathImg1']) || empty($pair['DescriptionImg'])) {
                                Log::warning('[GameService][createByGameType] Item inválido modo ID', ['index' => $index, 'pair' => $pair]);
                                continue;
                            }

                            // Procesar PathImg1
                            $upload1 = StorageUtility::uploadImage(
                                $pair['PathImg1'],
                                $destino,
                                null, // Generar nombre automáticamente
                                ['jpg', 'jpeg', 'png'],
                                'memory_'
                            );

                            if (empty($upload1['success'][0])) {
                                Log::error('[GameService][createByGameType] Error subiendo PathImg1', ['errores' => $upload1['errors']]);
                                continue;
                            }

                            MemoryGame::create([
                                'GameInstanceId' => $gameInstanceId,
                                'Mode' => 'ID',
                                'PathImg1' => $upload1['success'][0], 
                                'PathImg2' => null, 
                                'DescriptionImg' => $pair['DescriptionImg'],
                            ]);
                        }
                    } catch (\Exception $e) {
                        Log::error('[GameService][createByGameType] Error creando MemoryGame', ['error' => $e->getMessage(), 'pair' => $pair]);
                    }
                }

                // Guardar configuraciones del juego (obligatorio)
                if (!empty($data['Settings']) && is_array($data['Settings'])) {
                    foreach ($data['Settings'] as $setting) {
                        if (!empty($setting['ConfigKey']) && isset($setting['ConfigValue'])) {
                            GameSettings::create([
                                'GameInstanceId' => $gameInstanceId,
                                'ConfigKey' => $setting['ConfigKey'],
                                'ConfigValue' => $setting['ConfigValue'],
                            ]);
                        }
                    }
                } else {
                    Log::warning('[GameService][createByGameType] Settings faltantes para Memory game', ['gameInstanceId' => $gameInstanceId]);
                }

                return 'Memory game created successfully';


            case 'puzzle':
                if (empty($data['PathImg'])) {
                    Log::error('[GameService][createByGameType] PathImg vacío para puzzle', ['data' => $data]);
                    return 'For Puzzle game, PathImg is required';
                }

                // Procesar imagen (base64 o ruta local)
                $destino = rtrim(env('PATH_STORAGE'), '/\\') . DIRECTORY_SEPARATOR . 'puzzle';

                Log::info('[GameService][createByGameType] Procesando imagen puzzle', [
                    'destino' => $destino,
                    'pathImg_sample' => substr($data['PathImg'], 0, 100)
                ]);

                $upload = StorageUtility::uploadImage(
                    $data['PathImg'],
                    $destino,
                    null, 
                    ['jpg', 'jpeg', 'png'],
                    'puzzle_'
                );

                if (!empty($upload['success'][0])) {
                    $data['PathImg'] = $upload['success'][0]; 
                    Log::info('[GameService][createByGameType] Imagen puzzle guardada', ['ruta' => $data['PathImg']]);
                } else {
                    Log::error('[GameService][createByGameType] Error subiendo imagen puzzle', ['errores' => $upload['errors']]);
                    return 'Error uploading PathImg: ' . implode(', ', $upload['errors']);
                }

                Log::info('[GameService][createByGameType] Antes de crear Puzzle', ['gameInstanceId' => $gameInstanceId, 'data' => $data]);
                try {
                    $puzzle = Puzzle::create([
                        'GameInstanceId' => $gameInstanceId,
                        'PathImg' => $data['PathImg'], 
                        'Clue' => $data['Clue'] ?? '',
                        'Rows' => $data['Rows'] ?? 3,
                        'Cols' => $data['Cols'] ?? 3,
                        'AutomaticHelp' => $data['AutomaticHelp'] ?? 0,
                    ]);
                } catch (\Exception $e) {
                    Log::error('[GameService][createByGameType] Error creando Puzzle', ['error' => $e->getMessage(), 'data' => $data]);
                    return 'Error creating Puzzle: ' . $e->getMessage();
                }
                Log::info('[GameService][createByGameType] Puzzle creado', ['puzzleId' => $puzzle->GameInstanceId]);

                // Guardar configuraciones del juego (Settings)
                if (!empty($data['Settings']) && is_array($data['Settings'])) {
                    foreach ($data['Settings'] as $setting) {
                        if (!empty($setting['ConfigKey']) && isset($setting['ConfigValue'])) {
                            try {
                                GameSettings::create([
                                    'GameInstanceId' => $gameInstanceId,
                                    'ConfigKey' => $setting['ConfigKey'],
                                    'ConfigValue' => $setting['ConfigValue'],
                                ]);
                                Log::info('[GameService][createByGameType] Setting guardado para Puzzle', [
                                    'gameInstanceId' => $gameInstanceId,
                                    'ConfigKey' => $setting['ConfigKey'],
                                    'ConfigValue' => $setting['ConfigValue']
                                ]);
                            } catch (\Exception $e) {
                                Log::error('[GameService][createByGameType] Error guardando Setting para Puzzle', [
                                    'error' => $e->getMessage(),
                                    'setting' => $setting
                                ]);
                            }
                        }
                    }
                } else {
                    Log::warning('[GameService][createByGameType] Settings faltantes para Puzzle game', ['gameInstanceId' => $gameInstanceId]);
                }

                return 'Puzzle game created successfully';
            case 'solve_the_word':
                try {
                    $solveTheWord = SolveTheWord::create([
                        'GameInstanceId' => $gameInstanceId,
                        'Rows' => $data['Rows'] ?? 5, 
                        'Cols' => $data['Cols'] ?? 5, 
                    ]);
                } catch (\Exception $e) {
                    Log::error('[GameService][createByGameType] Error creando SolveTheWord', ['error' => $e->getMessage(), 'data' => $data]);
                    return 'Error creating SolveTheWord: ' . $e->getMessage();
                }
                Log::info('[GameService][createByGameType] SolveTheWord creado', ['solveTheWordId' => $solveTheWord->GameInstanceId]);
                if (!empty($data['Words']) && is_array($data['Words'])) {
                    foreach ($data['Words'] as $wordData) {
                        try {
                            Word::create([
                                'SolveTheWordId' => $solveTheWord->GameInstanceId, 
                                'Word' => $wordData['Word'] ?? '',
                                'Orientation' => $wordData['Orientation'] ?? 'HR',
                            ]);
                        } catch (\Exception $e) {
                            Log::error('[GameService][createByGameType] Error creando Word', ['error' => $e->getMessage(), 'wordData' => $wordData]);
                        }
                    }
                }

                // Guardar configuraciones del juego (Settings)
                if (!empty($data['Settings']) && is_array($data['Settings'])) {
                    foreach ($data['Settings'] as $setting) {
                        if (!empty($setting['ConfigKey']) && isset($setting['ConfigValue'])) {
                            try {
                                GameSettings::create([
                                    'GameInstanceId' => $gameInstanceId,
                                    'ConfigKey' => $setting['ConfigKey'],
                                    'ConfigValue' => $setting['ConfigValue'],
                                ]);
                                Log::info('[GameService][createByGameType] Setting guardado para SolveTheWord', [
                                    'gameInstanceId' => $gameInstanceId,
                                    'ConfigKey' => $setting['ConfigKey'],
                                    'ConfigValue' => $setting['ConfigValue']
                                ]);
                            } catch (\Exception $e) {
                                Log::error('[GameService][createByGameType] Error guardando Setting para SolveTheWord', [
                                    'error' => $e->getMessage(),
                                    'setting' => $setting
                                ]);
                            }
                        }
                    }
                } else {
                    Log::warning('[GameService][createByGameType] Settings faltantes para SolveTheWord game', ['gameInstanceId' => $gameInstanceId]);
                }

                return 'Solve the word game created successfully';
            default:
                Log::error('[GameService][createByGameType] Tipo de juego inválido', ['gameType' => $gameType]);
                return 'Invalid game type';
        }
    }

    /**
     * Genera un reporte de sesiones y estadísticas para un juego específico.
     */
    public function ratingsByGame(int $gameInstanceId)
    {
        $gameInstance = GameInstance::find($gameInstanceId);

        if (!$gameInstance) {
            throw new \Exception("Game instance not found");
        }

        // Detectar tipo de juego
        $gameType = match (true) {
            $gameInstance->hangman()->exists() => 'Hangman',
            $gameInstance->memorygame()->exists() => 'Memory',
            $gameInstance->puzzle()->exists() => 'Puzzle',
            $gameInstance->solvetheword()->exists() => 'Solve The Word',
            default => 'Unknown'
        };

        // Obtener todos los comentarios del assessment asociados a esa instancia
        $assessments = Assessment::with('userId')  // relación con User
            ->where('GameInstanceId', $gameInstanceId)
            ->whereNotNull('Comments')
            ->get();

        // Obtener las programaciones para mapear ProgrammingGameId => Nombre
        $programmings = ProgrammingGame::where('GameInstancesId', $gameInstanceId)->get()->keyBy('Id');

        // Obtener las sesiones para mapear userId => programming name
        $sessionMap = GameSessions::whereIn('ProgrammingGameId', $programmings->keys())
            ->get()
            ->groupBy('StudentId');

        $comments = [];

        foreach ($assessments as $assessment) {
            $user = $assessment->userId;

            // Encontrar la primera programación (si existe)
            $programmingName = 'No registrada';
            if (isset($sessionMap[$assessment->UserId])) {
                $firstSession = $sessionMap[$assessment->UserId]->first();
                $programmingName = $programmings[$firstSession->ProgrammingGameId]->Name ?? 'No encontrada';
            }

            $comments[] = [
                'comment' => $assessment->Comments,
                'rating' => $assessment->Value,
                'user' => $user ? "{$user->Name} {$user->LastName}" : 'Desconocido',
                'programming_name' => $programmingName,
            ];
        }

        return [
            'game_name' => $gameInstance->Name,
            'game_type' => $gameType,
            'comments' => $comments,
        ];
    }


    /**
     * Devuelve la configuración completa de un juego, incluyendo detalles específicos según el tipo.
     */
    public function getConfig(int $gameInstanceId, int $userId, bool $withProgrammings = false)
    {
        $game = GameInstance::find($gameInstanceId);
        if (!$game) {
            throw new \Exception('Game instance not found');
        }

        // Verificar si el participante ha sido calificado para esta instancia de juego
        $hasBeenAssessed = Assessment::where('GameInstanceId', $gameInstanceId)
            ->where('UserId', $userId)
            ->exists();

        // Obtener programaciones si se requiere
        $programmings = null;
        if ($withProgrammings) {
            $programmings = ProgrammingGame::where('GameInstancesId', $gameInstanceId)
                ->get()
                ->map(function ($programming) use ($userId) {
                    $assessed = Assessment::where('GameInstanceId', $programming->GameInstancesId)
                        ->where('UserId', $userId)
                        ->exists();
                    return [
                        'id' => $programming->Id,
                        'name' => $programming->Name,
                        'start_time' => $programming->StartTime,
                        'end_time' => $programming->EndTime,
                        'attempts' => $programming->Attempts,
                        'maximum_time' => $programming->MaximumTime,
                        'activated' => (bool) $programming->Activated,
                        'assessed' => $assessed,
                    ];
                });
        }

        // Hangman
        $hangmanWords = Hangman::where('GameInstanceId', $gameInstanceId)
            ->get(['Word as word', 'Clue as clue', 'Presentation as presentation'])
            ->toArray();
        if (empty($hangmanWords))
            $hangmanWords = null;

        // Memory
        $memoryPairs = MemoryGame::where('GameInstanceId', $gameInstanceId)
            ->get()
            ->map(function ($memory) {
                return [
                    'mode' => $memory->Mode,
                    'path_image1' => $memory->PathImg1,
                    'path_image2' => $memory->PathImg2,
                    'description_image' => $memory->DescriptionImg,
                ];
            })
            ->toArray();

        if (empty($memoryPairs)) {
            $memoryPairs = null;
        }

        // Puzzle
        $puzzle = Puzzle::where('GameInstanceId', $gameInstanceId)->first();
        $puzzleData = null;
        if ($puzzle) {
            $puzzleData = [
                'path_img' => $puzzle->PathImg,
                'clue' => $puzzle->Clue,
                'rows' => $puzzle->Rows,
                'cols' => $puzzle->Cols,
                'automatic_help' => (bool) $puzzle->AutomaticHelp,
            ];
        }

        // Solve the Word
        $solve = SolveTheWord::where('GameInstanceId', $gameInstanceId)->first();
        $solveWords = null;
        if ($solve) {
            $solveWords = Word::where('SolveTheWordId', $solve->GameInstanceId)
                ->get(['Word as word', 'Orientation as orientation'])
                ->toArray();
        }

        // Settings
        $settings = GameSettings::where('GameInstanceId', $gameInstanceId)
            ->get(['ConfigKey as key', 'ConfigValue as value'])
            ->toArray();
        if (empty($settings))
            $settings = null;

        return [
            'game_instance_id' => $game->Id,
            'game_name' => $game->Name,
            'game_description' => $game->Description,
            'difficulty' => $game->Difficulty,
            'visibility' => $game->Visibility,
            'activated' => (bool) $game->Activated,
            'assessed' => $hasBeenAssessed,
            'programmings' => $programmings,
            'hangman_words' => $hangmanWords,
            'memory_pairs' => $memoryPairs,
            'puzzle' => $puzzleData,
            'solve_the_word' => $solveWords,
            'settings' => $settings,
        ];
    }

    public function createGameSession(int $programmingGameId, int $studentId, array $data): string
    {
        // Validar datos de la sesión
        $validator = Validator::make($data, [
            'Duration' => 'required|integer|min:1',
            'Won' => 'required|boolean',
            'DateGame' => 'required|date',
            'Progress' => 'required|array', // Se espera un JSON válido
        ]);

        if ($validator->fails()) {
            return 'Error: ' . implode('; ', $validator->errors()->all());
        }

        // Crear la sesión
        $session = new GameSessions([
            'ProgrammingGameId' => $programmingGameId,
            'StudentId' => $studentId,
            'Duration' => $data['Duration'],
            'Won' => $data['Won'],
            'DateGame' => now(), // Fecha actual
        ]);

        $session->save();

        // Crear el progreso relacionado
        $progress = new GameProgress([
            'GameSessionId' => $session->Id,
            'Progress' => json_encode($data['Progress'], JSON_UNESCAPED_UNICODE)
        ]);

        $progress->save();

        return 'Game session and progress created successfully. Session ID: ' . $session->Id;
    }

    public function getGameProgressByInstanceAndUser(int $gameInstanceId, int $userId): array|string
    {
        // Buscar la programación del juego
        $programmings = ProgrammingGame::where('GameInstancesId', $gameInstanceId)->pluck('Id');

        if ($programmings->isEmpty()) {
            return "No programming found for this game instance.";
        }

        // Buscar la sesión del usuario en cualquiera de las programaciones
        $session = GameSessions::whereIn('ProgrammingGameId', $programmings)
            ->where('StudentId', $userId)
            ->orderByDesc('DateGame') // para traer la última jugada
            ->first();

        if (!$session) {
            return "No session found for user in this game instance.";
        }

        $progress = GameProgress::where('GameSessionId', $session->Id)->first();

        if (!$progress) {
            return "No progress found for the user's session.";
        }

        $decoded = json_decode($progress->Progress, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return "Progress data is invalid JSON.";
        }

        return $decoded;
    }

    public function updateGameSessionByInstanceAndUser(int $gameInstanceId, int $userId, array $data): string
    {
        // Validar los datos de entrada
        $validator = Validator::make($data, [
            'Duration' => 'required|integer|min:1',
            'Won' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return 'Error: ' . implode('; ', $validator->errors()->all());
        }

        // Buscar la programación relacionada con la instancia
        $programmingIds = ProgrammingGame::where('GameInstancesId', $gameInstanceId)->pluck('Id');

        // Buscar la última sesión del usuario en esa instancia
        $session = GameSessions::whereIn('ProgrammingGameId', $programmingIds)
            ->where('StudentId', $userId)
            ->latest('DateGame')
            ->first();

        if (!$session) {
            return 'Error: No session found for this user and game instance.';
        }

        // Actualizar datos
        $session->Duration = $data['Duration'];
        $session->Won = $data['Won'];
        $session->save();

        return 'Game session updated successfully. Session ID: ' . $session->Id;
    }

    public function privacityGame(int $gameInstanceId, string $privacity): string
    {
        $gameInstance = GameInstance::find($gameInstanceId);
        if (!$gameInstance) {
            return 'Game instance not found';
        }

        // Validar el valor de privacidad
        if (!in_array($privacity, ['P', 'R'])) {
            return 'Invalid privacy value. Use "P" for public or "R" for restricted.';
        }

        $gameInstance->Visibility = $privacity;
        $gameInstance->save();

        return 'Game instance privacy updated successfully';
    }

    public function averageAssessment(int $userId): array|string
    {
        $user = User::find($userId);
        if (!$user) {
            return 'User not found';
        }
        $gameInstances = GameInstance::where('ProfessorId', $userId)->pluck('Id');
        // ahora todos los asessments de las instancias de juego del profesor pero calculate the average que califican otros usuarios
        $average = Assessment::whereIn('GameInstanceId', $gameInstances)
            ->where('UserId', '!=', $userId) // Excluir las calificaciones del propio profesor
            ->avg('Value');

        return [
            'average_assessment' => $average
        ];
    }
}
