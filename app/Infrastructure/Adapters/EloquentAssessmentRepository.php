<?php

namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

class EloquentAssessmentRepository implements AssessmentRepository
{
    public function createAssessment(array $data): Assessment {
        return Assessment::create($data);
    }
    public function getAllAssessments(): array {
        return array_map(function (Assessment $assessment) {
            return $assessment->toArray();
        }, Assessment::all()->toArray());
    }
    public function getById(int $id): Assessment {
        return Assessment::find($id);
    }
    public function updateAssessment(int $id, array $data): Assessment {
        $assessment = Assessment::find($id);
        if ($assessment) {
            $assessment->update($data);
        }
        return $assessment;
    }
}