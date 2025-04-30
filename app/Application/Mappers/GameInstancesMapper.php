<?php
namespace App\Application\Mappers;

use App\Application\DTOs\GameInstancesDTO;
use App\Domain\Entities\GameInstances;

class GameInstancesMapper {
    public static function toEntity(GameInstancesDTO $dto): GameInstances {
        return new GameInstances([
            'Name' => $dto->Name,
            'Description' => $dto->Description,
            'ProfessorId'=> $dto->ProfessorId,
            'Activated'=> $dto->Activated,
            'Difficulty'=> $dto->Difficulty,
            'Visibility'=> $dto->Visibility
        ]);
    }

    public static function toDTO(GameInstances $gameInstance): GameInstancesDTO {
        return new GameInstancesDTO([
            'Name' => $gameInstance->Name,
            'Description' => $gameInstance->Description,
            'ProfessorId'=> $gameInstance->ProfessorId,
            'Activated'=> $gameInstance->Activated,
            'Difficulty'=> $gameInstance->Difficulty,
            'Visibility'=> $gameInstance->Visibility
        ]);
    }
    
    public static function toArray(GameInstances $gameInstance): array {
        return [
            'Id' => $gameInstance->Id,
            'Name' => $gameInstance->Name,
            'Description' => $gameInstance->Description,
            'ProfessorId'=> $gameInstance->ProfessorId,
            'Activated'=> $gameInstance->Activated,
            'Difficulty'=> $gameInstance->Difficulty,
            'Visibility'=> $gameInstance->Visibility
        ];
    }
}