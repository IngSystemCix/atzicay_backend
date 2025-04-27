<?php

namespace App\Application\UseCase\Assessment;

use App\Application\DTOs\AssessmentDTO;
use App\Application\Mappers\AssessmentMapper;
use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

class UpdateAssessmentUseCase {
    public function __construct(
        private AssessmentRepository $repository
    ) {}
    
    public function execute(int $id, AssessmentDTO $data): Assessment {
        $assessment = $this->repository->getAssessmentById($id);
        if (!$assessment) {
            throw new \RuntimeException("Assessment not found for ID: $id");
        }

        // Map the DTO to the entity
        $updatedAssessment = AssessmentMapper::toEntity($data);
        return $this->repository->updateAssessment($id, $updatedAssessment->toArray());
    }
}