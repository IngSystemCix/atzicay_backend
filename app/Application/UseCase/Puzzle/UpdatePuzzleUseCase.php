<?php
namespace App\Application\UseCase\Puzzle;

use App\Application\DTOs\PuzzleDTO;
use App\Application\Mappers\PuzzleMapper;
use App\Domain\Entities\Puzzle;
use App\Domain\Repositories\PuzzleRepository;

class UpdatePuzzleUseCase {
    public function __construct(
        private PuzzleRepository $repository
    ) {}
    
    public function execute(int $id, PuzzleDTO $data): Puzzle {
        $puzzle = $this->repository->getPuzzleById($id);
        if (!$puzzle) {
            throw new \RuntimeException("Puzzle not found for ID: $id");
        }

        // Map the DTO to the entity
        $updatePuzzle = Puzzle::toEntity($data);
        return $this->repository->updatePuzzle($id, $updatePuzzle->toArray());
    }
}

