<?php
namespace App\Application\UseCase\SolveTheWord;

use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\SolveTheWordRepository;

class GetSolveTheWordByIdUseCase{
    public function __construct(
        private SolveTheWordRepository $repository
    ){}

    public function execute(int $id): SolveTheWord{
        $solveTheWord = $this->repository->getSolveTheWordById($id);
        if(! $solveTheWord){
            throw new \Exception("Solve the word not found for ID: $id");
        }
        return $solveTheWord;
    }
}