<?php
namespace App\Application\UseCase\ProgrammingGame;

use App\Application\DTOs\ProgrammingGameDTO;
use App\Application\Mappers\ProgrammingGameMapper;
use App\Domain\Entities\ProgrammingGame;
use App\Domain\Repositories\ProgrammingGameRepository;

class CreateProgrammingGameUseCase
{
    public function __construct(
        private ProgrammingGameRepository $repository,
    ) {}

    public function execute(ProgrammingGameDTO $dto): ProgrammingGame
    {
        $programmingGame = ProgrammingGameMapper::toEntity($dto);
        $this->repository->createProgrammingGame(ProgrammingGameMapper::toArray($programmingGame));
        return $programmingGame;
    }
}