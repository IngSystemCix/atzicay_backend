<?php
namespace App\Application\UseCase\ProgrammingGame;

use App\Domain\Repositories\ProgrammingGameRepository;

class GetAllProgrammingGamesUseCase
{
    public function __construct(
        private ProgrammingGameRepository $programmingGameRepository
    ){}

    public function execute($limit = 6, $offset = 0): array
    {
        return $this->programmingGameRepository->getAllProgrammingGames($limit, $offset);
    }
}