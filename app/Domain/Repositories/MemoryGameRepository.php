<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\MemoryGame;

interface MemoryGameRepository
{
    public function getAllMemoryGames(): array;
    public function getMemoryGameById(int $id): MemoryGame;
    public function createMemoryGame(array $data): MemoryGame;
    public function updateMemoryGame(int $id, array $data): MemoryGame;
}