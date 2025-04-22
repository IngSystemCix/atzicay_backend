<?php

namespace App\Application\UseCase\Assessment;

use App\Application\DTOs\Assessment\CreateAssessmentDTO;
use App\Application\Mappers\Assessment\CreateAssessmentMapper;
use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

class CreateAssessmentUseCase {
    public function __construct(
        private AssessmentRepository $repository
    ) {}

    public function execute(CreateAssessmentDTO $dto): Assessment {
        $assessment = CreateAssessmentMapper::toEntity($dto);
        return $this->repository->createAssessment($assessment->toArray());
    }
}