<?php

namespace App\Infrastructure\Adapters;

use App\Domain\Entities\MemoryGame;
use App\Domain\Repositories\MemoryGameRepository;

class EloquentMemoryGameRepository implements MemoryGameRepository
{
    public function createMemoryGame(array $data): MemoryGame{
        return MemoryGame::Create($data);
    }

    public function getAllMemoryGame(): array{
        return array_map(function(MemoryGame $memoryGame){
            return $memoryGame->toArray();
        },MemoryGame::all()->toArray());
    }

    public function getMemoryGameById(int $id): MemoryGame{
        return MemoryGame::find($id);
    }

    public function updateMemoryGame(int $id, int $data): MemoryGame{
        $memoryGame = MemoryGame::find($id);
        if($memoryGame){
            return $memoryGame->update($data);
        }
        return $memoryGame;
    }

    public function deleteMemoryGame(int $id): MemoryGame{
        $memoryGame = MemoryGame::find($id);
        if($memoryGame){
            return $memoryGame->delete();
        }
        return $memoryGame;
    }
}