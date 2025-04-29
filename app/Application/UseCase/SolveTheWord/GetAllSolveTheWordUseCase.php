<?php
namespace App\Application\UseCase\SolveTheWord;

use App\Domain\Repositories\SolveTheWordRepository;

class GetAllSolveTheWordUseCase{
    public function __construct(
        private SolveTheWordRepository $repository
    ){}

    public function execute(): array{
        return $this->repository->getAllSolveTheWord();
    }
}