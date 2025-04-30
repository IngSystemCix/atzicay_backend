<?php
namespace App\Application\UseCase\Puzzle;

use App\Application\DTOs\PuzzleDTO;
use App\Application\Mappers\PuzzleMapper;
use App\Domain\Entities\Puzzle;
use App\Domain\Repositories\PuzzleRepository;

class UpdatePuzzleUseCase {
    public function __construct(
        private PuzzleRepository $puzzleRepository,
    ){}

    public function execute(int $id, PuzzleDTO $dto): Puzzle {
        $puzzle = $this->puzzleRepository->getPuzzleById($id);
        if (!$puzzle) {
            throw new \RuntimeException("Puzzle not found for ID: $id");
        }
        $updatedPuzzle = PuzzleMapper::toEntity($dto);
        return $this->puzzleRepository->updatePuzzle($id, PuzzleMapper::toArray($updatedPuzzle));
    }
}