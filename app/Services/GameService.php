<?php

namespace App\Services;

use App\Models\GameInstance;
use App\Models\GameSessions;
use App\Models\GameSettings;
use App\Models\Hangman;
use App\Models\MemoryGame;
use App\Models\Puzzle;
use App\Models\SolveTheWord;
use App\Models\Word;
use Illuminate\Support\Facades\DB;
use App\Utils\StorageUtility;

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

        $gameInstance->Visibility = $status;
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
        // Crear instancia base del juego
        $gameInstance = GameInstance::create([
            'Name' => $data['Name'] ?? 'New Game Instance',
            'Description' => $data['Description'] ?? '',
            'ProfessorId' => $professorId,
            'Activated' => $data['Activated'] ?? true,
            'Difficulty' => $data['Difficulty'] ?? 'Easy',
            'Visibility' => $data['Visibility'] ?? 'Public',
        ]);

        $gameInstanceId = $gameInstance->Id;

        switch (strtolower($gameType)) {
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
                break;

            case 'memory':
                $pathImage1 = '';
                if (!empty($data['PathImage1'])) {
                    $upload1 = StorageUtility::uploadImage(
                        $data['PathImage1'],
                        env('PATH_STORAGE', '') . '/memory',
                        'memory_' . $gameInstanceId . '_'
                    );
                    $pathImage1 = $upload1['success'][0] ?? '';
                }

                $pathImage2 = '';
                if (($data['Mode'] ?? 'II') === 'II' && !empty($data['PathImage2'])) {
                    $upload2 = StorageUtility::uploadImage(
                        $data['PathImage2'],
                        env('PATH_STORAGE', '') . '/memory',
                        'memory_' . $gameInstanceId . '_'
                    );
                    $pathImage2 = $upload2['success'][0] ?? '';
                }

                MemoryGame::create([
                    'GameInstanceId' => $gameInstanceId,
                    'Mode' => $data['Mode'] ?? 'II',
                    'PathImage1' => $pathImage1,
                    'PathImage2' => $pathImage2,
                    'Description' => $data['Description'] ?? '',
                ]);
                break;

            case 'puzzle':
                $pathImg = '';
                if (!empty($data['PathImg'])) {
                    $upload = StorageUtility::uploadImage(
                        $data['PathImg'],
                        env('PATH_STORAGE', '') . '/puzzle',
                        'puzzle_' . $gameInstanceId . '_'
                    );
                    $pathImg = $upload['success'][0] ?? '';
                }

                Puzzle::create([
                    'GameInstanceId' => $gameInstanceId,
                    'PathImg' => $pathImg,
                    'Clue' => $data['Clue'] ?? '',
                    'Rows' => $data['Rows'] ?? 3,
                    'Cols' => $data['Cols'] ?? 3,
                    'AutomaticHelp' => $data['AutomaticHelp'] ?? 0,
                ]);
                break;

            case 'solve_the_word':
                $solveTheWord = SolveTheWord::create([
                    'GameInstanceId' => $gameInstanceId,
                    'Rows' => $data['Rows'] ?? 10,
                    'Cols' => $data['Cols'] ?? 10,
                ]);

                if (!empty($data['Words']) && is_array($data['Words'])) {
                    foreach ($data['Words'] as $wordData) {
                        Word::create([
                            'SolveTheWordId' => $solveTheWord->Id,
                            'Word' => $wordData['Word'] ?? '',
                            'Orientation' => $wordData['Orientation'] ?? 'HR',
                        ]);
                    }
                }
                break;

            default:
                return 'Invalid game type';
        }

        // Agregar configuración (GameSettings) si se proporciona
        if (!empty($data['Settings']) && is_array($data['Settings'])) {
            foreach ($data['Settings'] as $setting) {
                GameSettings::create([
                    'GameInstanceId' => $gameInstanceId,
                    'ConfigKey' => $setting['Key'] ?? '',
                    'ConfigValue' => $setting['Value'] ?? '',
                ]);
            }
        }

        return ucfirst($gameType) . ' game created successfully';
    }

    public function reportByGame(int $gameInstanceId): array
    {
        return GameSessions::selectRaw("
            CONCAT(users.Name, ' ', users.LastName) AS user,
            MONTHNAME(gamesessions.DateGame) AS month_name,
            YEAR(gamesessions.DateGame) AS year,
            COUNT(gamesessions.Id) AS total_sessions,
            SUM(gamesessions.Duration) AS total_minutes_played,
            ROUND(AVG(gamesessions.Duration), 2) AS avg_minutes_per_session
        ")
            ->join('users', 'users.Id', '=', 'gamesessions.StudentId')
            ->where('gamesessions.ProgrammingGameId', $gameInstanceId)
            ->groupBy('users.Id', 'users.Name', 'users.LastName', 'month_name', 'year')
            ->orderByRaw('year ASC, MONTH(gamesessions.DateGame) ASC')
            ->get()
            ->toArray();
    }

    public function getConfig(int $gameInstanceId)
    {
        $gameInstance = GameInstance::with([
            'hangman',
            'memorygame',
            'puzzle',
            'solvetheword',
            'gamesettings'
        ])->where('Id', $gameInstanceId)->first();

        if (!$gameInstance) {
            return null; // o puedes lanzar una excepción o retornar un error customizado
        }

        $response = [
            'game_instance_id' => $gameInstance->Id,
            'game_name' => $gameInstance->Name,
            'game_description' => $gameInstance->Description,
            'difficulty' => $gameInstance->Difficulty,
            'visibility' => $gameInstance->Visibility,
            'activated' => $gameInstance->Activated,
        ];

        // Hangman words (solo si hay datos)
        if ($gameInstance->hangman->isNotEmpty()) {
            $response['hangman_words'] = $gameInstance->hangman->map(function ($item) {
                return [
                    'word' => $item->Word,
                    'clue' => $item->Clue,
                    'presentation' => $item->Presentation,
                ];
            })->toArray();
        }

        // Memory pairs (solo si hay datos)
        if ($gameInstance->memorygame->isNotEmpty()) {
            $response['memory_pairs'] = $gameInstance->memorygame->map(function ($item) {
                return [
                    'mode' => $item->Mode,
                    'path_image1' => $item->PathImg1,
                    'path_image2' => $item->PathImg2,
                    'description_image' => $item->DescriptionImg,
                ];
            })->toArray();
        }

        // Puzzle (solo si existe)
        if ($gameInstance->puzzle) {
            $response['puzzle'] = [
                'path_img' => $gameInstance->puzzle->PathImg,
                'clue' => $gameInstance->puzzle->Clue,
                'rows' => $gameInstance->puzzle->Rows,
                'cols' => $gameInstance->puzzle->Cols,
                'automatic_help' => $gameInstance->puzzle->AutomaticHelp,
            ];
        }

        // Solve The Word (solo si hay datos)
        if ($gameInstance->solvetheword->isNotEmpty()) {
            $response['solve_the_word'] = $gameInstance->solvetheword->map(function ($item) {
                return [
                    'word' => $item->Word,
                    'orientation' => $item->Orientation,
                ];
            })->toArray();
        }

        // Settings (solo si hay datos)
        if ($gameInstance->gamesettings->isNotEmpty()) {
            $response['settings'] = $gameInstance->gamesettings->map(function ($item) {
                return [
                    'key' => $item->ConfigKey,
                    'value' => $item->ConfigValue,
                ];
            })->toArray();
        }

        return $response;
    }
}
