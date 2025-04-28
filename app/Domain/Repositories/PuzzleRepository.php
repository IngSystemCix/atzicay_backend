<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Puzzle;

interface PuzzleRepository
{
    public function createPuzzle(array $data): Puzzle;
    public function getAllPuzzle(): array;
    public function getPuzzleById(int $id): Puzzle;
    public function updatePuzzle(int $id, int $data): Puzzle;
    public function deletePuzzle(int $id): Puzzle;
}