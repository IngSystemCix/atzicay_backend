<?php
namespace App\Application\UseCase\GameProgress;

use App\Application\DTOs\GameProgressDTO;
use App\Application\Mappers\GameProgressMapper;
use App\Domain\Entities\GameProgress;
use App\Domain\Repositories\GameProgressRepository;

class UpdateGameProgressUseCase 
{
    public function __construct(
        private GameProgressRepository $repository,
    ) {}

    public function execute(int $id, GameProgressDTO $dto): GameProgress
    {
        $gameProgress = $this->repository->getGameProgressById($id);
        if (!$gameProgress) {
            throw new \RuntimeException("Game progress not found for ID: $id");
        }

        $updatedGameProgress = GameProgressMapper::toEntity($dto);
        return $this->repository->updateGameProgress($id, GameProgressMapper::toArray($updatedGameProgress));
    }
}