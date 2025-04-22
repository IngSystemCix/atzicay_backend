<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Assessment;

interface AssessmentRepository
{
    public function createAssessment(array $data): Assessment;
}