<?php
namespace App\Application\Mappers;

use App\Application\DTOs\ProgrammingGameDTO;
use App\Domain\Entities\ProgrammingGame;

class ProgrammingGameMapper
{
    public static function toEntity(ProgrammingGameDTO $dto): ProgrammingGame
    {
        return new ProgrammingGame([
            'GameInstancesId' => $dto->GameInstancesId,
            'ProgrammerId' => $dto->ProgrammerId,
            'Name' => $dto->Name,
            'Activated' => $dto->Activated,
            'StartTime' => $dto->StartTime,
            'EndTime' => $dto->EndTime,
            'Attempts' => $dto->Attempts,
            'MaximumTime' => $dto->MaximumTime
        ]);
    }

    public static function toDTO(ProgrammingGame $programmingGame): ProgrammingGameDTO
    {
        return new ProgrammingGameDTO([
            'GameInstancesId' => $programmingGame->GameInstancesId,
            'ProgrammerId' => $programmingGame->ProgrammerId,
            'Name' => $programmingGame->Name,
            'Activated' => $programmingGame->Activated,
            'StartTime' => $programmingGame->StartTime,
            'EndTime' => $programmingGame->EndTime,
            'Attempts' => $programmingGame->Attempts,
            'MaximumTime' => $programmingGame->MaximumTime
        ]);
    }

    public static function toArray(ProgrammingGame $programmingGame): array
    {
        return [
            'Id' => $programmingGame->Id,
            'GameInstancesId' => $programmingGame->GameInstancesId,
            'ProgrammerId' => $programmingGame->ProgrammerId,
            'Name' => $programmingGame->Name,
            'Activated' => $programmingGame->Activated,
            'StartTime' => $programmingGame->StartTime,
            'EndTime' => $programmingGame->EndTime,
            'Attempts' => $programmingGame->Attempts,
            'MaximumTime' => $programmingGame->MaximumTime
        ];
    }
}