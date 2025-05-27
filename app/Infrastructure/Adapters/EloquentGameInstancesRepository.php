<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\GameInstances;
use App\Domain\Repositories\GameInstancesRepository;

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

    public function getAllGameInstances(): array
    {
        return GameInstances::all()->toArray();
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

    public function getAllGame(int $limit = 6): array
    {
        $games = GameInstances::with([
            'professor',
            'assessments',
            'hangman',
            'memoryGame',
            'puzzle',
            'solveTheWord'
        ])
            ->where('Activated', true)
            ->take($limit)
            ->get()
            ->map(function ($game) {
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
                    'level' => $game->Difficulty,
                    'description' => $game->Description,
                    'rating' => $game->assessments->avg('Value') ?? 0,
                    'author' => $game->professor
                        ? $game->professor->Name . ' ' . $game->professor->LastName
                        : 'Unknown',
                    'type' => $type,
                ];
            })->toArray();

        return $games;
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
