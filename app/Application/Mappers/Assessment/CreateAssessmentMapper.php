<?php

namespace App\Application\Mappers\Assessment;

use App\Application\DTOs\Assessment\CreateAssessmentDTO;
use App\Domain\Entities\Assessment;

class CreateAssessmentMapper {
    public static function toEntity(CreateAssessmentDTO $dto): Assessment {
        return new Assessment([
            'Activated' => $dto->activated,
            'GameInstanceId' => $dto->gameInstanceId,
            'UserId' => $dto->userId,
            'Value' => $dto->value,
            'Comments' => $dto->comments,
        ]);
    }

    public static function toDTO(Assessment $assessment): CreateAssessmentDTO {
        return new CreateAssessmentDTO(
            activated: $assessment->Activated,
            gameInstanceId: $assessment->GameInstanceId,
            userId: $assessment->UserId,
            value: $assessment->Value,
            comments: $assessment->Comments
        );
    }
}