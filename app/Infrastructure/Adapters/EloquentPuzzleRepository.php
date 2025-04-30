<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Puzzle;
use App\Domain\Repositories\PuzzleRepository;

class EloquentPuzzleRepository implements PuzzleRepository
{
    public function createPuzzle(array $data): Puzzle {
        return Puzzle::create([
            'GameInstanceId' => $data['GameInstanceId'],
            'PathImg'=> $data['PathImg'],
            'Clue'=> $data['Clue'],
            'Rows'=> $data['Rows'],
            'Cols'=> $data['Cols'],
            'AutomaticHelp'=> $data['AutomaticHelp'],
        ]);
    }

    public function getPuzzleById(int $id): Puzzle {
        $puzzle = Puzzle::find($id);
        if (!$puzzle) {
            throw new \RuntimeException("Puzzle not found with ID: $id");
        }
        return $puzzle;
    }
    
    public function updatePuzzle(int $id, array $data): Puzzle {
        $puzzle = Puzzle::find($id);
        if (!$puzzle) {
            throw new \RuntimeException("Puzzle not found with ID: $id");
        }
        $puzzle->update([
            'GameInstanceId' => $data['GameInstanceId'],
            'PathImg'=> $data['PathImg'],
            'Clue'=> $data['Clue'],
            'Rows'=> $data['Rows'],
            'Cols'=> $data['Cols'],
            'AutomaticHelp'=> $data['AutomaticHelp'],
        ]);
        return $puzzle;
    }
}