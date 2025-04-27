<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Assessment;

interface AssessmentRepository
{
    public function createAssessment(array $data): Assessment;
    public function getAllAssessments(): array;
    public function getAssessmentById(int $id): Assessment;
    public function updateAssessment(int $id, array $data): Assessment;
}