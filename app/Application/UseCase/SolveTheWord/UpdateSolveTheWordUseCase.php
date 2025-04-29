<?php
namespace App\Application\UseCase\SolveTheWord;

use App\Application\DTOs\SolveTheWordDTO;
use App\Application\Mappers\SolveTheWordMapper;
use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\SolveTheWordRepository;

class UpdateSolveTheWordUseCase{
    public function __construct(
        private SolveTheWordRepository $repository
    ){}

    public function execute(int $id, SolveTheWordDTO $data): SolveTheWord {
        $solveTheWord = $this->repository->getSolveTheWordById($id);
        if(! $solveTheWord){
            throw new \Exception("Solve the word not found for ID: $id");
        }

        //Map de DTO to the entity
        $updateSolveTheWord = SolveTheWordMapper::toEntity($data);
        return $this->repository->updateSolveTheWord($id, $updateSolveTheWord->toArray());
    }
}