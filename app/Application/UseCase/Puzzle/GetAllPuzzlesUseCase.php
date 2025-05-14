<?php

namespace App\Application\UseCase\Puzzle;

use App\Domain\Repositories\PuzzleRepository;


class GetAllPuzzlesUseCase
{
    public function __construct(private PuzzleRepository $puzzleRepository) {}

    /**
     * @return array
     */
    public function execute(): array
    {
        return $this->puzzleRepository->getAllPuzzles();
    }
}