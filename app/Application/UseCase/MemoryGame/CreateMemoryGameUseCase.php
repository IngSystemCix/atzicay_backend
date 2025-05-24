<?php
namespace App\Application\UseCase\MemoryGame;

use App\Application\DTOs\MemoryGameDTO;
use App\Application\Mappers\MemoryGameMapper;
use App\Domain\Entities\MemoryGame;
use App\Domain\Repositories\MemoryGameRepository;

class CreateMemoryGameUseCase
{
    public function __construct(
        private MemoryGameRepository $repository,
    ) {}

    public function execute(MemoryGameDTO $dto): MemoryGame
    {
        $memoryGame = MemoryGameMapper::toEntity($dto);
        $this->repository->createMemoryGame(MemoryGameMapper::toArray($memoryGame));
        return $memoryGame;
    }
}