<?php

namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Puzzle;
use App\Domain\Repositories\PuzzleRepository;

class EloquentPuzzleRepository implements PuzzleRepository
{
    public function createPuzzle(array $data): Puzzle{
        return Puzzle::Create($data);
    }

    public function getAllPuzzle(): array{
        return array_map(function(Puzzle $puzzle){
            return $puzzle->toArray();
        },Puzzle::all()->toArray());
    }

    public function getPuzzleById(int $id): Puzzle{
        return Puzzle::find($id);
    }

    public function updatePuzzle(int $id, int $data): Puzzle{
        $puzzle = Puzzle::find($id);
        if($puzzle){
            return $puzzle->update($data);
        }
        return $puzzle;
    }

    public function deletePuzzle(int $id): Puzzle{
        $puzzle = Puzzle::find($id);
        if($puzzle){
            return $puzzle->delete();
        }
        return $puzzle;
    }
}