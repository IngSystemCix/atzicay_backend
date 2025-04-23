<?php

namespace App\Application\UseCase\Assessment;

use App\Application\DTOs\AssessmentDTO;
use App\Application\Mappers\Assessment\CreateAssessmentMapper;
use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

class CreateAssessmentUseCase {
    public function __construct(
        private AssessmentRepository $repository
    ) {}

    public function execute(AssessmentDTO $dto): Assessment {
        $assessment = CreateAssessmentMapper::toEntity($dto);
        return $this->repository->createAssessment($assessment->toArray());
    }
}