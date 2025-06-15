<?php
namespace App\Application\UseCase\GameInstances;

use App\Domain\Repositories\GameInstancesRepository;

class GetAllGameUseCase
{
    public function __construct(
        private GameInstancesRepository $repository
    ) {}

    public function execute($limit = 6, $offset = 0): array
    {
        return $this->repository->getAllGame($limit, $offset);
    }
}