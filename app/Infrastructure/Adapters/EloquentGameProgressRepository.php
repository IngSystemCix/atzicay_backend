<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\GameProgress;
use App\Domain\Repositories\GameProgressRepository;

class EloquentGameProgressRepository implements GameProgressRepository {

    public function createGameProgress(array $data): GameProgress {
        return GameProgress::create([
            'GameSessionId' => $data['GameSessionId'],
            'Progress' => $data['Progress'],
        ]);
    }

    public function getGameProgressById(int $id): GameProgress {
        $gameProgress = GameProgress::find($id);
        if (!$gameProgress) {
            throw new \RuntimeException("Game progress not found with ID: $id");
        }
        return $gameProgress;
    }

    public function updateGameProgress(int $id, array $data): GameProgress {
        $gameProgress = GameProgress::find($id);
        if (!$gameProgress) {
            throw new \RuntimeException("Game progress not found with ID: $id");
        }
        $gameProgress->update([
            'GameSessionId' => $data['GameSessionId'],
            'Progress' => $data['Progress'],
        ]);
        return $gameProgress;
    }
}