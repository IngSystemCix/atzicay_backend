<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\GameInstances;
use App\Domain\Repositories\GameInstancesRepository;

class EloquentGameInstancesRepository implements GameInstancesRepository {

    public function createGameInstance(array $data): GameInstances {
        return GameInstances::create([
            'Name' => $data['Name'],
            'Description' => $data['Description'],
            'ProfessorId'=> $data['ProfessorId'],
            'Activated'=> $data['Activated'],
            'Difficulty'=> $data['Difficulty'],
            'Visibility'=> $data['Visibility']
        ]);
    }
    
    public function deleteGameInstance(int $id): GameInstances {
        $gameInstance = GameInstances::findOrFail($id);
        $gameInstance->Activated = false;
        $gameInstance->save();
        return $gameInstance;
    }
    
    public function getAllGameInstances(): array {
        return GameInstances::all()->toArray();
    }
    
    public function getGameInstanceById(int $id): GameInstances {
        $gameInstance = GameInstances::find($id);

        if (!$gameInstance) {
            throw new \RuntimeException("Game instance not found with ID: $id");
        }

        return $gameInstance;
    }
    
    public function updateGameInstance(int $id, array $data): GameInstances {
        $gameInstance = GameInstances::find($id);

        if (!$gameInstance) {
            throw new \RuntimeException("Game instance not found with ID: $id");
        }
        $gameInstance->update([
            'Name' => $data['Name'],
            'Description' => $data['Description'],
            'ProfessorId'=> $data['ProfessorId'],
            'Activated'=> $data['Activated'],
            'Difficulty'=> $data['Difficulty'],
            'Visibility'=> $data['Visibility']
        ]);
        return $gameInstance;
    }
}