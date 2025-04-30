<?php
namespace App\Application\UseCase\GameProgress;

use App\Application\DTOs\GameProgressDTO;
use App\Application\Mappers\GameProgressMapper;
use App\Domain\Entities\GameProgress;
use App\Domain\Repositories\GameProgressRepository;

class CreateGameProgressUseCase
{
    public function __construct(
        private GameProgressRepository $repository,
    ) {}

    public function execute(GameProgressDTO $dto): GameProgress
    {
        $gameProgress = GameProgressMapper::toEntity($dto);
        $this->repository->createGameProgress(GameProgressMapper::toArray($gameProgress));
        return $gameProgress;
    }
}