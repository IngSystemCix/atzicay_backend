<?php
namespace App\Application\UseCase\SolveTheWord;

use App\Application\Mappers\SolveTheWordMapper;
use App\Domain\Repositories\SolveTheWordRepository;

class DeleteSolveTheWordUsecase{
    public function __construct(
        private SolveTheWordRepository $repository
    ){}

    public function execute(int $id){
        $solveTheWord = $this->repository->getSolveTheWordById($id);
        if(! $solveTheWord){
            throw new \Exception("Solve The Word not founf by ID: $id");
        }

        //Map the DTO to entity
        $deleteSolveTheWord = SolveTheWordMapper::toEntity($id);
        return $this->repository->deleteSolveTheWord($id,$deleteSolveTheWord->toArray());
    }
}