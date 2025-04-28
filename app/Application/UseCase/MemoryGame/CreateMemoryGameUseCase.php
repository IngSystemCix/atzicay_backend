<?php

namespace App\Application\UseCase\MemoryGame;

use App\Application\DTOs\MemoryGameDTO;
use App\Application\Mappers\MemoryGameMapper;
use App\Domain\Entities\MemoryGame;
use App\Domain\Repository\MemoryGameRepository;

class CreateMemoryGameUseCase{
    public function __construct(
        private MemoryGameRepository $repositoy
    ){}

    public function execute(MemoryGameDTO $dto): MemoryGame{
        $memoryGame = MemoryGameMapper::toEntity($dto);
        return $this->repositoy->createMemoryGame(data: $memoryGame->toArray());
    }
}