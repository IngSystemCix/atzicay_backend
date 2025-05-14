<?php

namespace App\Application\UseCase\MemoryGame;

use App\Domain\Repositories\MemoryGameRepository;


class GetAllMemoryGamesUseCase
{
    public function __construct(private MemoryGameRepository $memoryGameRepository){}

    /**
     * @return array
     */
    public function execute(): array
    {
        return $this->memoryGameRepository->getAllMemoryGames();
    }
}