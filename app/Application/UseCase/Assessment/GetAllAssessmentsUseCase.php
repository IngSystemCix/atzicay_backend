<?php

namespace App\Application\UseCase\Assessment;

use App\Domain\Repositories\AssessmentRepository;

/**
 * Use case for retrieving all assessments.
 */
class GetAllAssessmentsUseCase
{
    /**
     * Constructor for GetAllAssessmentsUseCase.
     *
     * @param AssessmentRepository $repository The repository for managing assessments.
     */
    public function __construct(
        private AssessmentRepository $repository
    ) {}

    /**
     * Executes the use case to retrieve all assessments.
     *
     * @return array The list of all assessments.
     */
    public function execute(): array
    {
        return $this->repository->getAllAssessments();
    }
}