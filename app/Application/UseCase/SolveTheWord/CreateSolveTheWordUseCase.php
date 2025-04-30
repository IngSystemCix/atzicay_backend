<?php
namespace App\Application\UseCase\SolveTheWord;

use App\Application\DTOs\SolveTheWordDTO;
use App\Application\Mappers\SolveTheWordMapper;
use App\Domain\Entities\SolveTheWord;
use App\Domain\Repositories\SolveTheWordRepository;

class CreateSolveTheWordUseCase {
    public function __construct(
        private SolveTheWordRepository $repository,
    ) {}

    public function execute(SolveTheWordDTO $dto): SolveTheWord {
        $solveTheWord = SolveTheWordMapper::toEntity($dto);
        $this->repository->createSolveTheWord(SolveTheWordMapper::toArray($solveTheWord));
        return $solveTheWord;
    }
}