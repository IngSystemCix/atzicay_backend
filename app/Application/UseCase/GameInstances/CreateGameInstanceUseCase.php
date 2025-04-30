<?php
namespace App\Application\UseCase\GameInstances;

use App\Application\DTOs\GameInstancesDTO;
use App\Application\Mappers\GameInstancesMapper;
use App\Domain\Entities\GameInstances;
use App\Domain\Repositories\GameInstancesRepository;

class CreateGameInstanceUseCase
{
    public function __construct(
        private GameInstancesRepository $repository
    ) {}

    public function execute(GameInstancesDTO $dto): GameInstances
    {
        $gameInstance = GameInstancesMapper::toEntity($dto);
        $this->repository->createGameInstance(GameInstancesMapper::toArray($gameInstance));
        return $gameInstance;
    }
}