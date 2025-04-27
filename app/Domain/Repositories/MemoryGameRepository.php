<?php

namespace App\Domain\Repositories;
use App\Domain\Entities\MemoryGame;

interface MemoryGameRepository
{
    public function createMemoryGame(MemoryGame $memoryGame): MemoryGame;
    public function getAllMemoryGame(): array;
    public function getById(int $id): MemoryGame;
    public function updateMemoryGame(MemoryGame $memoryGame): MemoryGame;
    public function deleteMemoryGame(MemoryGame $memoryGame): MemoryGame;
    
}