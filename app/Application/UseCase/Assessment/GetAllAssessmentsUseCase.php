<?php

namespace App\Application\UseCase\Assessment;

use App\Domain\Repositories\AssessmentRepository;

class GetAllAssessmentsUseCase
{
    public function __construct(
        private AssessmentRepository $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->getAllAssessments();
    }
}