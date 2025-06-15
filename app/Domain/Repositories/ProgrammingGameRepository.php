<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\ProgrammingGame;

interface ProgrammingGameRepository
{
    public function getAllProgrammingGames(int $limit = 6, int $offset = 0): array;
    public function getProgrammingGameById(int $id): ProgrammingGame;
    public function createProgrammingGame(array $data): ProgrammingGame;
    public function updateProgrammingGame(int $id, array $data): ProgrammingGame;
    public function deleteProgrammingGame(int $id): ProgrammingGame;
}