<?php
namespace App\Application\UseCase\Puzzle;

use App\Domain\Entities\Puzzle;
use App\Domain\Repositories\PuzzleRepository;

class GetPuzzleByIdUseCase {
    public function __construct(
        private PuzzleRepository $repository
    ){}

    public function execute(int $id): Puzzle {
        $puzzle = $this->repository->getPuzzleById($id);
        if (!$puzzle) {
            throw new \RuntimeException("Puzzle not found for ID: $id");
        }
        return $puzzle;
    }
}