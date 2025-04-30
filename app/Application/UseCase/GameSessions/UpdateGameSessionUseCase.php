<?php
namespace App\Application\UseCase\GameSessions;

use App\Application\DTOs\GameSessionsDTO;
use App\Application\Mappers\GameSessionsMapper;
use App\Domain\Entities\GameSession;
use App\Domain\Repositories\GameSessionsRepository;

class UpdateGameSessionUseCase {
    public function __construct(
        private GameSessionsRepository $repository
    ) {}

    public function execute(int $id, GameSessionsDTO $data): GameSession
    {
        $gameSession = $this->repository->getGameSessionById($id);
        if (!$gameSession) {
            throw new \RuntimeException("Game session not found for ID: $id");
        }

        $updatedGameSession = GameSessionsMapper::toEntity($data);
        return $this->repository->updateGameSession($id, GameSessionsMapper::toArray($updatedGameSession));
    }
}