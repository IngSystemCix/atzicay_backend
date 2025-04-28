<?php

namespace App\Application\UseCase\Puzzle;

use App\Application\DTOs\PuzzleDTO;
use App\Application\Mappers\PuzzleMapper;
use App\Domain\Entities\Puzzle;
use App\Domain\Repository\PuzzleRepository;

class CreatePuzzleUseCase{
    public function __construct(
        private PuzzleRepository $repositoy
    ){}

    public function execute(PuzzleDTO $dto): Puzzle{
        $puzzle = PuzzleMapper::toEntity($dto);
        return $this->repositoy->createPuzzle(data: $puzzle->toArray());
    }
}