<?php
namespace App\Application\UseCase\GameInstances;

use App\Application\DTOs\GameInstancesDTO;
use App\Application\Mappers\GameInstancesMapper;
use App\Domain\Entities\GameInstances;
use App\Domain\Repositories\GameInstancesRepository;

class DeleteGameInstanceUseCase
{
    public function __construct(
        private GameInstancesRepository $repository
    ) {}

    public function execute(int $id): GameInstances
    {
        $gameInstance = $this->repository->getGameInstanceById($id);
        if (!$gameInstance) {
            throw new \RuntimeException("Game instance not found for ID: $id");
        }

        return $this->repository->deleteGameInstance($id);
    }
}