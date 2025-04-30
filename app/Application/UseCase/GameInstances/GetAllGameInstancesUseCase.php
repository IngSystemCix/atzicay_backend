<?php
namespace App\Application\UseCase\GameInstances;

use App\Domain\Repositories\GameInstancesRepository;

class GetAllGameInstancesUseCase
{
    public function __construct(
        private GameInstancesRepository $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->getAllGameInstances();
    }
}