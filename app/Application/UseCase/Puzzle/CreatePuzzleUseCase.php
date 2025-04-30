<?php
namespace App\Application\UseCase\Puzzle;

use App\Application\DTOs\PuzzleDTO;
use App\Application\Mappers\PuzzleMapper;
use App\Domain\Entities\Puzzle;
use App\Domain\Repositories\PuzzleRepository;

class CreatePuzzleUseCase
{
    public function __construct(
        private PuzzleRepository $repository,
    ) {}

    public function execute(PuzzleDTO $dto): Puzzle
    {
        $puzzle = PuzzleMapper::toEntity($dto);
        $this->repository->createPuzzle(PuzzleMapper::toArray($puzzle));
        return $puzzle;
    }
}