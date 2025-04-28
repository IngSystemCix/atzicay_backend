<?php
namespace App\Application\UseCase\MemoryGame;

use App\Application\DTOs\MemoryGameDTO;
use App\Application\Mappers\MemoryGameMapper;
use App\Domain\Entities\MemoryGame;
use App\Domain\Repositories\MemoryGameRepository;

class UpdateMemoryGameUseCase {
    public function __construct(
        private MemoryGameRepository $repository
    ) {}
    
    public function execute(int $id, MemoryGameDTO $data): MemoryGame {
        $memoryGame = $this->repository->getMemoryGameById($id);
        if (!$memoryGame) {
            throw new \RuntimeException("MemoryGame not found for ID: $id");
        }

        // Map the DTO to the entity
        $updatememoryGame = HangmanMapper::toEntity($data);
        return $this->repository->updateMemoryGame($id, $updatememoryGame->toArray());
    }
}

