<?php

namespace App\Application\UseCase\Assessment;

use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

/**
 * Use case for retrieving an assessment by its ID.
 */
class GetAssessmentByIdUseCase
{
    /**
     * Constructor for GetAssessmentByIdUseCase.
     *
     * @param AssessmentRepository $repository The repository for managing assessments.
     */
    public function __construct(
        private AssessmentRepository $repository
    ) {}

    /**
     * Executes the use case to retrieve an assessment by its ID.
     *
     * @param int $id The ID of the assessment to retrieve.
     * @return Assessment The retrieved assessment entity.
     * @throws \RuntimeException If the assessment is not found.
     */
    public function execute(int $id): Assessment
    {
        $assessment = $this->repository->getAssessmentById($id);

        if (!$assessment) {
            throw new \RuntimeException("Assessment not found for ID: $id");
        }

        return $assessment;
    }
}