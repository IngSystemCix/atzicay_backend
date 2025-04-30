<?php
namespace App\Application\UseCase\GameSessions;

use App\Application\DTOs\GameSessionsDTO;
use App\Application\Mappers\GameSessionsMapper;
use App\Domain\Entities\GameSession;
use App\Domain\Repositories\GameSessionsRepository;

class CreateGameSessionUseCase
{
    public function __construct(
        private GameSessionsRepository $repository,
    ) {}

    public function execute(GameSessionsDTO $dto): GameSession
    {
        $gameSession = GameSessionsMapper::toEntity($dto);
        $this->repository->createGameSession(GameSessionsMapper::toArray($gameSession));
        return $gameSession;
    }
}