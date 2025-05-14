<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Puzzle;

interface PuzzleRepository
{
    public function getAllPuzzles(): array;
    public function getPuzzleById(int $id): Puzzle;
    public function createPuzzle(array $data): Puzzle;
    public function updatePuzzle(int $id, array $data): Puzzle;
}