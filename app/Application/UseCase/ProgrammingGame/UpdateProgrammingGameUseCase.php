<?php
namespace App\Application\UseCase\ProgrammingGame;

use App\Application\DTOs\ProgrammingGameDTO;
use App\Application\Mappers\ProgrammingGameMapper;
use App\Domain\Entities\ProgrammingGame;
use App\Domain\Repositories\ProgrammingGameRepository;

class UpdateProgrammingGameUseCase
{
    public function __construct(
        private ProgrammingGameRepository $repository,
    ) {}

    public function execute(int $id, ProgrammingGameDTO $data): ProgrammingGame
    {
        $programmingGame = $this->repository->getProgrammingGameById($id);
        if (!$programmingGame) {
            throw new \RuntimeException("Programming game not found for ID: $id");
        }

        // Assuming ProgrammingGameMapper::toEntity() can handle partial updates
        $updatedProgrammingGame = ProgrammingGameMapper::toEntity($data);
        return $this->repository->updateProgrammingGame($id, ProgrammingGameMapper::toArray($updatedProgrammingGame));
    }
}