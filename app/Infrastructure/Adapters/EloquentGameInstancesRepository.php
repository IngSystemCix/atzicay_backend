<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\GameInstances;
use App\Domain\Entities\Hangman;
use App\Domain\Entities\MemoryGame;
use App\Domain\Entities\Puzzle;
use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\GameInstancesRepository;
use App\Domain\Services\CryptoUtil;
use Illuminate\Support\Env;

class EloquentGameInstancesRepository implements GameInstancesRepository
{

    public function createGameInstance(array $data): GameInstances
    {
        return GameInstances::create([
            'Name' => $data['Name'],
            'Description' => $data['Description'],
            'ProfessorId' => $data['ProfessorId'],
            'Activated' => $data['Activated'],
            'Difficulty' => $data['Difficulty'],
            'Visibility' => $data['Visibility']
        ]);
    }

    public function deleteGameInstance(int $id): GameInstances
    {
        $gameInstance = GameInstances::findOrFail($id);
        $gameInstance->Activated = false;
        $gameInstance->save();
        return $gameInstance;
    }

    public function getAllGameInstances(int $idProfessor, string $gameType = null, ?int $limit = 10, ?int $offset = 0): array
    {
        $key = Env::get('KEY_ENCRYPTION_KEY');
        $crypto = new CryptoUtil($key);

        $query = GameInstances::where('ProfessorId', $idProfessor)
            ->select('Name', 'Id', 'Description', 'ProfessorId', 'Difficulty', 'Visibility', 'Activated')
            ->with(['programmingGame', 'hangman', 'memoryGame', 'puzzle', 'solveTheWord'])
            ->distinct('Name');

        if ($gameType) {
            $gameType = strtolower($gameType);

            switch ($gameType) {
                case 'hangman':
                    $query->whereHas('hangman');
                    break;
                case 'memory':
                    $query->whereHas('memoryGame');
                    break;
                case 'puzzle':
                    $query->whereHas('puzzle');
                    break;
                case 'solve_the_word':
                    $query->whereHas('solveTheWord');
                    break;
                case 'programming':
                    $query->whereHas('programmingGame');
                    break;
                case 'all':
                    $query->where(function ($q) {
                        $q->whereHas('hangman')
                            ->orWhereHas('memoryGame')
                            ->orWhereHas('puzzle')
                            ->orWhereHas('solveTheWord')
                            ->orWhereHas('programmingGame');
                    });
                    break;
                default:
                    return [
                        'total' => 0,
                        'data' => []
                    ];
            }
        }

        // Obtener el total antes de aplicar limit
        $total = $query->count();

        // Aplicar limit y offset
        $results = $query->skip($offset)->take($limit)->get();

        // Transformar y encriptar los campos necesarios
        $data = $results->transform(function ($item) use ($crypto) {
            $data = $item->toArray();

            // Encriptar 'Id' y 'ProfessorId'
            $data['Id'] = $crypto->encrypt($data['Id']);
            $data['ProfessorId'] = $crypto->encrypt($data['ProfessorId']);

            // Determinar el tipo de juego
            if ($item->programmingGame !== null) {
                $data['gameType'] = 'programming';
                $data['programmingGameId'] = $crypto->encrypt($item->programmingGame->Id);
            } elseif ($item->hangman !== null) {
                $data['gameType'] = 'hangman';
                $data['programmingGameId'] = null;
            } elseif ($item->memoryGame !== null) {
                $data['gameType'] = 'memory';
                $data['programmingGameId'] = null;
            } elseif ($item->puzzle !== null) {
                $data['gameType'] = 'puzzle';
                $data['programmingGameId'] = null;
            } elseif ($item->solveTheWord !== null) {
                $data['gameType'] = 'solve_the_word';
                $data['programmingGameId'] = null;
            } else {
                $data['gameType'] = 'unknown';
                $data['programmingGameId'] = null;
            }

            // Agregar campo 'isProgrammed'
            $data['isProgrammed'] = $item->programmingGame !== null ? 1 : 0;

            // Eliminar relaciones cargadas
            unset($data['programming_game']);
            unset($data['hangman']);
            unset($data['memory_game']);
            unset($data['puzzle']);
            unset($data['solve_the_word']);

            return $data;
        })->toArray();

        return [
            'total' => $total,
            'data' => $data
        ];
    }


    public function countGameTypesByProfessor(int $idProfessor): array
    {
        return [
            'hangman' => Hangman::whereHas('gameInstances', function ($query) use ($idProfessor) {
                $query->where('ProfessorId', $idProfessor);
            })
                ->distinct('GameInstanceId')
                ->count('GameInstanceId'),

            'memory' => MemoryGame::whereHas('gameInstance', function ($query) use ($idProfessor) {
                $query->where('ProfessorId', $idProfessor);
            })
                ->distinct('GameInstanceId')
                ->count('GameInstanceId'),

            'puzzle' => Puzzle::whereHas('gameInstances', function ($query) use ($idProfessor) {
                $query->where('ProfessorId', $idProfessor);
            })
                ->count('GameInstanceId'),

            'solve_the_word' => SolveTheWord::whereHas('gameInstances', function ($query) use ($idProfessor) {
                $query->where('ProfessorId', $idProfessor);
            })
                ->count('GameInstanceId'),
        ];
    }


    public function getGameInstanceById(int $id): GameInstances
    {
        $gameInstance = GameInstances::find($id);

        if (!$gameInstance) {
            throw new \RuntimeException("Game instance not found with ID: $id");
        }

        return $gameInstance;
    }

    public function updateGameInstance(int $id, array $data): GameInstances
    {
        $gameInstance = GameInstances::find($id);

        if (!$gameInstance) {
            throw new \RuntimeException("Game instance not found with ID: $id");
        }
        $gameInstance->update([
            'Name' => $data['Name'],
            'Description' => $data['Description'],
            'ProfessorId' => $data['ProfessorId'],
            'Activated' => $data['Activated'],
            'Difficulty' => $data['Difficulty'],
            'Visibility' => $data['Visibility']
        ]);
        return $gameInstance;
    }

    public function getAllGame(int $limit = 6, int $offset = 0): array
    {
        $key = Env::get('KEY_ENCRYPTION_KEY');
        $crypto = new CryptoUtil($key);

        // Obtener el total de juegos activados (sin limit ni offset)
        $total = GameInstances::where('Activated', true)->count();

        // Obtener los juegos aplicando limit y offset
        $games = GameInstances::with([
            'professor',
            'assessments',
            'hangman',
            'memoryGame',
            'puzzle',
            'solveTheWord'
        ])
            ->where('Activated', true)
            ->skip($offset) // aplicar offset
            ->take($limit)  // aplicar limit
            ->get()
            ->map(function ($game) use ($crypto) {
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
                    'id' => $crypto->encrypt($game->Id),
                    'title' => $game->Name,
                    'level' => $game->Difficulty,
                    'description' => $game->Description,
                    'rating' => $game->assessments->avg('Value') ?? 0,
                    'author' => $game->professor
                        ? $game->professor->Name . ' ' . $game->professor->LastName
                        : 'Unknown',
                    'idProfessor' => $crypto->encrypt($game->ProfessorId),
                    'type' => $type,
                ];
            })->toArray();

        // Devolver la respuesta con datos paginados y total
        return [
            'total' => $total,
            'limit' => $limit,
            'offset' => $offset,
            'data' => $games
        ];
    }

    public function search(array $filters): array
    {
        $query = GameInstances::query()->with('professor');
        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['author'])) {
            $query->whereHas('professor', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['author'] . '%')
                    ->orWhere('lastName', 'like', '%' . $filters['author'] . '%');
            });
        }

        if (!empty($filters['type'])) {
            $query->where('name', $filters['type']);
        }

        if (!empty($filters['difficulty'])) {
            $query->where('difficulty', $filters['difficulty']);
        }
        return $query->get()->toArray();
    }
}
