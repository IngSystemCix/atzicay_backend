<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\SolveTheWordRepository;

class EloquentSolveTheWordRepository implements SolveTheWordRepository {

    public function createSolveTheWord(array $data): SolveTheWord {
        return SolveTheWord::create([
            "GameInstanceId"=> $data["GameInstanceId"],
            "Rows"=> $data["Rows"],
            "Cols"=> $data["Cols"]
        ]);
    }

    public function getSolveTheWordById(int $id): SolveTheWord {
        $solveTheWord = SolveTheWord::find($id);
        if (!$solveTheWord) {
            throw new \RuntimeException("SolveTheWord not found with ID: $id");
        }
        return $solveTheWord;
    }

    public function updateSolveTheWord(int $id, array $data): SolveTheWord {
        $solveTheWord = SolveTheWord::find($id);
        if (!$solveTheWord) {
            throw new \RuntimeException("SolveTheWord not found with ID: $id");
        }
        $solveTheWord->update([
            "GameInstanceId"=> $data["GameInstanceId"],
            "Rows"=> $data["Rows"],
            "Cols"=> $data["Cols"]
        ]);
        return $solveTheWord;
    }
}