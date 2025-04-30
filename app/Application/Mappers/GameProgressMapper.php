<?php
namespace App\Application\Mappers;

use App\Application\DTOs\GameProgressDTO;
use App\Domain\Entities\GameProgress;

class GameProgressMapper {
    public static function toEntity(GameProgressDTO $dto): GameProgress
    {
        return new GameProgress([
            'GameSessionId' => $dto->GameSessionId,
            'Progress' => $dto->Progress,
        ]);
    }

    public static function toDTO(GameProgress $gameProgress): GameProgressDTO
    {
        return new GameProgressDTO([
            'GameSessionId' => $gameProgress->GameSessionId,
            'Progress' => $gameProgress->Progress,
        ]);
    }

    public static function toArray(GameProgress $gameProgress): array
    {
        return [
            'Id' => $gameProgress->Id,
            'GameSessionId' => $gameProgress->GameSessionId,
            'Progress' => $gameProgress->Progress,
        ];
    }
}