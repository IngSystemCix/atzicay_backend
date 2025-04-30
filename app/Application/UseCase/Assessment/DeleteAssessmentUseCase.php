<?php
namespace App\Application\UseCase\Assessment;

use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

class DeleteAssessmentUseCase
{
    public function __construct(
        private AssessmentRepository $repository
    ) {}

    public function execute(int $id): Assessment
    {
        $assessment = $this->repository->getAssessmentById($id);
        if (!$assessment) {
            throw new \RuntimeException("Assessment not found for ID: $id");
        }

        return $this->repository->deleteAssessment($id);
    }
}