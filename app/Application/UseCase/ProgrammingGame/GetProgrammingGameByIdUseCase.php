<?php
namespace App\Application\UseCase\ProgrammingGame;

use App\Domain\Entities\ProgrammingGame;
use App\Domain\Repositories\ProgrammingGameRepository;

class GetProgrammingGameByIdUseCase
{
    public function __construct(
        private ProgrammingGameRepository $repository
    ) {}

    public function execute(int $id): ProgrammingGame
    {
        $programmingGame = $this->repository->getProgrammingGameById($id);
        if (!$programmingGame) {
            throw new \RuntimeException("Programming game not found for ID: $id");
        }
        return $programmingGame;
    }
}