<?php
namespace App\Application\UseCase\GameInstances;

use App\Domain\Repositories\GameInstancesRepository;

class GetAllGameInstancesUseCase
{
    public function __construct(
        private GameInstancesRepository $repository
    ) {}

    /**
     * @param int $idProfessor
     * @param string|null $gameType Puede ser 'all', 'hangman', 'memory', 'puzzle', 'solve_the_word' o null
     * @return array
     */
    public function execute(int $idProfessor, ?string $gameType = null, int $limit = 10, int $offset = 0): array
    {
        return $this->repository->getAllGameInstances($idProfessor, $gameType, $limit, $offset);
    }
}
