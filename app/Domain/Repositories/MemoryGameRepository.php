<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\MemoryGame;

interface MemoryGameRepository
{
    public function createMemoryGame(array $data): MemoryGame;
    public function getAllMemoryGame(): array;
    public function getMemoryGameById(int $id): MemoryGame;
    public function updateMemoryGame(int $id, int $data): MemoryGame;
    public function deleteMemoryGame(int $id): MemoryGame;
    
}