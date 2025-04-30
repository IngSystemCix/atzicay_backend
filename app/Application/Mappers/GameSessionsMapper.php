<?php
namespace App\Application\Mappers;

use App\Application\DTOs\GameSessionsDTO;
use App\Domain\Entities\GameSession;

class GameSessionsMapper {
    public static function toEntity(GameSessionsDTO $dto): GameSession {
        return new GameSession([
            'ProgrammingGameId' => $dto->ProgrammingGameId,
            'StudentId' => $dto->StudentId,
            'Duration' => $dto->Duration,
            'Won' => $dto->Won,
        ]);
    }

    public static function toDTO(GameSession $gameSession): GameSessionsDTO {
        return new GameSessionsDTO([
            'ProgrammingGameId' => $gameSession->ProgrammingGameId,
            'StudentId' => $gameSession->StudentId,
            'Duration' => $gameSession->Duration,
            'Won' => $gameSession->Won,
        ]);
    }

    public static function toArray(GameSession $gameSession): array {
        return [
            'Id' => $gameSession->Id,
            'ProgrammingGameId' => $gameSession->ProgrammingGameId,
            'StudentId' => $gameSession->StudentId,
            'Duration' => $gameSession->Duration,
            'Won' => $gameSession->Won,
            'DateGame' => $gameSession->DateGame,
        ];
    }
}