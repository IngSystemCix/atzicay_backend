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

    public function getAllGame(): array
    {
        $games = GameInstances::with('professor', 'assessments') // Cargar las relaciones correctamente
            ->where('Activated', true)
            ->get()
            ->map(function ($game) {
                $typeGame = null;
                switch ($typeGame) {
                    case $game->hangman:
                        $typeGame = 'Hangman';
                        break;
                    case $game->memory:
                        $typeGame = 'Memory';
                        break;
                    case $game->puzzle:
                        $typeGame = 'Puzzle';
                        break;
                    case $game->solveTheWord:
                        $typeGame = 'Solve the Word';
                        break;
                    default:
                        $typeGame = 'Unknown';
                        break;
                }
                return [
                    'id' => $game->Id,
                    'title' => $game->Name,
                    'level' => $game->Difficulty, // "E", "M", "H"
                    'description' => $game->Description,
                    'rating' => $game->assessments ? $game->assessments->avg('Value') : 0, // Asegurarse de que 'assessments' esté cargado
                    'author' => $game->professor ? $game->professor->Name . ' ' . $game->professor->LastName : 'Unknown', // Manejar casos donde 'professor' sea null
                    'type' => $typeGame,
                ];
            })->toArray();

        return $games;
    }

}