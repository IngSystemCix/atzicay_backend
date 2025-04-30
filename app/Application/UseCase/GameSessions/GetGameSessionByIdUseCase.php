<?php
namespace App\Application\UseCase\GameSessions;

use App\Domain\Entities\GameSession;
use App\Domain\Repositories\GameSessionsRepository;

class GetGameSessionByIdUseCase {
    public function __construct(
        private GameSessionsRepository $repository
    ) {}

    public function execute($id): GameSession {
        $gameSession = $this->repository->getGameSessionById($id);
        if (!$gameSession) {
            throw new \RuntimeException("Game session not found for ID: $id");
        }
        return $gameSession;
    }
}