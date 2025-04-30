<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\GameSession;
use App\Domain\Repositories\GameSessionsRepository;

class EloquentGameSessionsRepository implements GameSessionsRepository {

    public function createGameSession(array $data): GameSession {
        return GameSession::create([
            'ProgrammingGameId' => $data['ProgrammingGameId'],
            'StudentId'=> $data['StudentId'],
            'Duration'=> $data['Duration'],
            'Won'=> $data['Won'],
            'DateGame'=> now(),
        ]);
    }
    
    public function getGameSessionById(int $id): GameSession {
        $gameSession = GameSession::find($id);
        if (!$gameSession) {
            throw new \RuntimeException("Game session not found with ID: $id");
        }
        return $gameSession;
    }
    
    public function updateGameSession(int $id, array $data): GameSession {
        $gameSession = GameSession::find($id);
        if (!$gameSession) {
            throw new \RuntimeException("Game session not found with ID: $id");
        }
        $gameSession->update([
            'ProgrammingGameId' => $data['ProgrammingGameId'],
            'StudentId'=> $data['StudentId'],
            'Duration'=> $data['Duration'],
            'Won'=> $data['Won'],
            'DateGame'=> now(),
        ]);
        return $gameSession;
    }
}