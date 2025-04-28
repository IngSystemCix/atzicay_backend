<?php
namespace App\Application\UseCase\Puzzle;

use App\Domain\Repositories\PuzzleRepository;

class GetAllPuzzleUseCase{
    public function __construct(
        private PuzzleRepository $repository
    ){}
    public function execute(): array{
        return $this->repository->getAllPuzzle();
    }
}
    