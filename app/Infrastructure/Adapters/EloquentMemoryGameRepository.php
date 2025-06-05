<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\MemoryGame;
use App\Domain\Repositories\MemoryGameRepository;

class EloquentMemoryGameRepository implements MemoryGameRepository {
    public function createMemoryGame(array $data): MemoryGame {
        return MemoryGame::create([
            'GameInstanceId' => $data['GameInstanceId'],
            'Mode' => $data['Mode'],
            'PathImg1' => $data['PathImg1'],
            'PathImg2' => $data['PathImg2'],
            'DescriptionImg' => $data['DescriptionImg']
        ]);
    }
    
    public function getMemoryGameById(int $id): MemoryGame {
        $memoryGame = MemoryGame::find($id);
        if (! $memoryGame) {
            throw new \Exception('Memory game not found with ID: ' . $id);
        }
        return $memoryGame;
    }
    
    public function updateMemoryGame(int $id, array $data): MemoryGame {
        $memoryGame = MemoryGame::find($id);
        if (! $memoryGame) {
            throw new \Exception('Memory game not found with ID: ' . $id);
        }
        $memoryGame->update([
            'GameInstanceId' => $data['GameInstanceId'],
            'Mode' => $data['Mode'],
            'PathImg1' => $data['PathImg1'],
            'PathImg2' => $data['PathImg2'],
            'DescriptionImg' => $data['DescriptionImg']
        ]);
        return $memoryGame;
    }
}