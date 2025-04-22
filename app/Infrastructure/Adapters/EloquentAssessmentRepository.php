<?php

namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

class EloquentAssessmentRepository implements AssessmentRepository
{
    public function createAssessment(array $data): Assessment {
        return Assessment::create($data);
    }
}