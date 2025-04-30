<?php
namespace App\Application\UseCase\SolveTheWord;

use App\Application\DTOs\SolveTheWordDTO;
use App\Application\Mappers\SolveTheWordMapper;
use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\SolveTheWordRepository;

class UpdateSolveTheWordUseCase {
    public function __construct(
        private SolveTheWordRepository $repository
    ) {}

    public function execute($id, SolveTheWordDTO $dto): SolveTheWord {
        $solveTheWord = $this->repository->getSolveTheWordById($id);
        if (! $solveTheWord) {
            throw new \RuntimeException("SolveTheWord not found for ID: $id");
        }
        $updateSolveTheWord = SolveTheWordMapper::toEntity($dto);
        return $this->repository->updateSolveTheWord($id, SolveTheWordMapper::toArray($updateSolveTheWord));
    }
}