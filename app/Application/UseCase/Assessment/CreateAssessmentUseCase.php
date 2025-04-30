<?php
namespace App\Application\UseCase\Assessment;

use App\Application\DTOs\AssessmentDTO;
use App\Application\Mappers\AssessmentMapper;
use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

/**
 * Use case for creating an assessment.
 */
class CreateAssessmentUseCase {
    /**
     * Constructor for CreateAssessmentUseCase.
     *
     * @param AssessmentRepository $repository The repository for managing assessments.
     */
    public function __construct(
        private AssessmentRepository $repository
    ) {}

    /**
     * Executes the use case to create an assessment.
     *
     * @param AssessmentDTO $dto The data transfer object containing assessment details.
     * @return Assessment The created assessment entity.
     */
    public function execute(AssessmentDTO $dto): Assessment {
        $assessment = AssessmentMapper::toEntity($dto);
        return $this->repository->createAssessment(AssessmentMapper::toArray($assessment));
    }
}