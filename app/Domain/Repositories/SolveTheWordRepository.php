<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\SolveTheWord;

interface SolveTheWordRepository {
    public function getAllSolveTheWords(): array;
    public function getSolveTheWordById(int $id): SolveTheWord;
    public function createSolveTheWord(array $data): SolveTheWord;
    public function updateSolveTheWord(int $id, array $data): SolveTheWord;
}