<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\GameSession;

interface GameSessionsRepository
{
    public function getGameSessionById(int $id): GameSession;
    public function createGameSession(array $data): GameSession;
    public function updateGameSession(int $id, array $data): GameSession;
}