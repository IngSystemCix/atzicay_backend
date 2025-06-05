<?php

namespace App\Application\UseCase\GameInstances;

use App\Domain\Repositories\GameInstancesRepository;

class CountGameTypesByProfessorUseCase
{
    public function __construct(
        private GameInstancesRepository $repository
    ) {}

    public function execute(int $idProfessor): array
    {
        return $this->repository->countGameTypesByProfessor($idProfessor);
    }
}
