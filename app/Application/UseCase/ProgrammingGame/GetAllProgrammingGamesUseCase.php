<?php
namespace App\Application\UseCase\ProgrammingGame;

use App\Domain\Repositories\ProgrammingGameRepository;

class GetAllProgrammingGamesUseCase
{
    public function __construct(
        private ProgrammingGameRepository $programmingGameRepository
    ){}

    public function execute()
    {
        return $this->programmingGameRepository->getAllProgrammingGames();
    }
}