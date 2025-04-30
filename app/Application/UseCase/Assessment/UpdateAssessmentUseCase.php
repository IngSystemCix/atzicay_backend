<?php

namespace App\Application\UseCase\Assessment;

use App\Application\DTOs\AssessmentDTO;
use App\Application\Mappers\AssessmentMapper;
use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

/**
 * Use case for updating an existing assessment.
 */
class UpdateAssessmentUseCase {
    /**
     * Constructor for UpdateAssessmentUseCase.
     *
     * @param AssessmentRepository $repository The repository for managing assessments.
     */
    public function __construct(
        private AssessmentRepository $repository
    ) {}
    
    /**
     * Executes the use case to update an assessment.
     *
     * @param int $id The ID of the assessment to update.
     * @param AssessmentDTO $data The data transfer object containing updated assessment details.
     * @return Assessment The updated assessment entity.
     * @throws \RuntimeException If the assessment is not found.
     */
    public function execute(int $id, AssessmentDTO $data): Assessment {
        $assessment = $this->repository->getAssessmentById($id);
        if (!$assessment) {
            throw new \RuntimeException("Assessment not found for ID: $id");
        }

        // Map the DTO to the entity
        $updatedAssessment = AssessmentMapper::toEntity($data);
        return $this->repository->updateAssessment($id, AssessmentMapper::toArray($updatedAssessment));
    }
}