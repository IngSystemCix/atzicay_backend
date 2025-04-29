<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\SolveTheWordRepository;

class EloquentSolveTheWordRepository implements SolveTheWordRepository
{
    public function createSolveTheWord(array $data): SolveTheWord{
        return SolveTheWord::create($data);
    }

    public function getAllSolveTheWord(): array{
        return arrap_map(function(SolveTheWord $solveTheWord){
            return $solveTheWord->toArray();
        },SolveTheWord::All()->toArray());
    }

    public function getSolveTheWordById(int $id): SolveTheWord{
        return SolveTheWord::find($id);
    }

    public function updateSolveTheWord(int $id, array $data): SolveTheWord{
        $solveTheWord = SolveTheWord::find($id);
        if($solveTheWord){
            return $solveTheWord->update($data);
        }
        return $solveTheWord;
    }

    public function deleteSolveTheWord(int $id): SolveTheWord{
        $solveTheWord = SolveTheWord::find($id);
        if($solveTheWord){
            return $solveTheWord->delete();
        }
        return $solveTheWord;
    }
}