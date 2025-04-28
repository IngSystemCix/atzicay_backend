<?php
namespace App\Application\UseCase\MemoryGame;

use App\Domain\Repositories\MemoryGameRepository;

class GetAllMemoryGameUseCase{
    public function __construct(
        private MemoryGameRepository $repository
    ){}
    public function execute(): array{
        return $this->repository->getAllMemoryGame();
    }
}
    