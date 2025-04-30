<?php
namespace App\Application\UseCase\GameInstances;

use App\Domain\Entities\GameInstances;
use App\Domain\Repositories\GameInstancesRepository;

class GetGameInstanceByIdUseCase
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
        return $gameInstance;
    }
}