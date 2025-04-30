<?php
namespace App\Application\UseCase\GameInstances;

use App\Application\DTOs\GameInstancesDTO;
use App\Application\Mappers\GameInstancesMapper;
use App\Domain\Entities\GameInstances;
use App\Domain\Repositories\GameInstancesRepository;

class UpdateGameInstanceUseCase
{
    public function __construct(
        private GameInstancesRepository $repository
    ) {}

    public function execute(int $id, GameInstancesDTO $dto): GameInstances
    {
        $gameInstance = $this->repository->getGameInstanceById($id);
        if (!$gameInstance) {
            throw new \RuntimeException("Game instance not found for ID: $id");
        }

        $updatedGameInstance = GameInstancesMapper::toEntity($dto);
        return $this->repository->updateGameInstance($id, GameInstancesMapper::toArray($updatedGameInstance));
    }
}