<?php
namespace App\Application\Mappers;

use App\Application\DTOs\AssessmentDTO;
use App\Domain\Entities\Assessment;

/**
 * Mapper class for converting between Assessment entities, DTOs, and arrays.
 */
class AssessmentMapper {
    /**
     * Maps an AssessmentDTO to an Assessment entity.
     *
     * @param AssessmentDTO $dto The AssessmentDTO to map.
     * @return Assessment The mapped Assessment entity.
     */
    public static function toEntity(AssessmentDTO $dto): Assessment {
        return new Assessment([
            'Activated' => $dto->Activated,
            'GameInstanceId' => $dto->GameInstanceId,
            'UserId' => $dto->UserId,
            'Value' => $dto->Value,
            'Comments' => $dto->Comments,
        ]);
    }

    /**
     * Maps an Assessment entity to an AssessmentDTO.
     *
     * @param Assessment $assessment The Assessment entity to map.
     * @return AssessmentDTO The mapped AssessmentDTO.
     */
    public static function toDTO(Assessment $assessment): AssessmentDTO {
        return new AssessmentDTO([
            'Id' => $assessment->Id,
            'Activated' => $assessment->Activated,
            'GameInstanceId' => $assessment->GameInstanceId,
            'UserId' => $assessment->UserId,
            'Value' => $assessment->Value,
            'Comments' => $assessment->Comments,
        ]);
    }

    /**
     * Maps an Assessment entity to an associative array.
     *
     * @param Assessment $assessment The Assessment entity to map.
     * @return array<string, mixed> The mapped associative array.
     */
    public static function toArray(Assessment $assessment): array {
        return [
            'Id' => $assessment->Id,
            'Activated' => $assessment->Activated,
            'GameInstanceId' => $assessment->GameInstanceId,
            'UserId' => $assessment->UserId,
            'Value' => $assessment->Value,
            'Comments' => $assessment->Comments,
        ];
    }
}