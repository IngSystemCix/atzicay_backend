<?php
namespace App\Application\UseCase\MemoryGame;

use App\Domain\Entities\MemoryGame;
use App\Domain\Repositories\MemoryGameRepository;

class GetMemoryGameByIdUseCase {
    public function __construct(
        private MemoryGameRepository $repository
    ) {}

    public function execute(int $id): MemoryGame {
        $memoryGame = $this->repository->getMemoryGameById($id);
        if (!$memoryGame) {
            throw new \RuntimeException("Memory game not found for ID: $id");
        }
        return $memoryGame;
    }
}