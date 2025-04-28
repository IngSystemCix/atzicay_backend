<?php

namespace App\Application\UseCase\Puzzle;

use App\Application\Mappers\PuzzleMapper;
use App\Domain\Repositories\PuzzleRepository;

class DeletePuzzleUseCase{
    public function __construct(
    private PuzzleRepository $repository
    ){}

    public function execute(int $id): void{
        $puzzle = $this->repository->getPuzzleById($id);
        if(!$puzzle){
            throw new \Exception("Puzzle not found by ID: $id");
        }
        // Map the DTO to the entity
         $deletePuzzle = PuzzleMapper::toEntity($id);
        return $this->repository->deletePuzzle($id, $deletePuzzle->toArray());
    }
}