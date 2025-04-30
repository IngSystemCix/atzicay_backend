<?php
namespace App\Application\UseCase\GameProgress;

use App\Domain\Entities\GameProgress;
use App\Domain\Repositories\GameProgressRepository;

class GetGameProgressByIdUseCase 
{
    public function __construct(
        private GameProgressRepository $repository
    ) {}

    public function execute($id): GameProgress {
        $gameProgress = $this->repository->getGameProgressById($id);
        if (!$gameProgress) {
            throw new \RuntimeException("Game progress not found for ID: $id");
        }
        return $gameProgress;
    }
}