<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\ProgrammingGame;

interface ProgrammingGameRepository
{
    public function getAllProgrammingGames(): array;
    public function getProgrammingGameById(int $id): ProgrammingGame;
    public function createProgrammingGame(array $data): ProgrammingGame;
    public function updateProgrammingGame(int $id, array $data): ProgrammingGame;
    public function deleteProgrammingGame(int $id): ProgrammingGame;
}