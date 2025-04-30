<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Assessment;
use App\Domain\Repositories\AssessmentRepository;

class EloquentAssessmentRepository implements AssessmentRepository
{
    /**
     * Creates a new assessment.
     *
     * @param array $data The data for creating the assessment.
     * @return Assessment The created assessment entity.
     */
    public function createAssessment(array $data): Assessment {
        return Assessment::create([
            'Activated' => $data['Activated'],
            'GameInstanceId' => $data['GameInstanceId'],
            'UserId' => $data['UserId'],
            'Value' => $data['Value'],
            'Comments' => $data['Comments'],
        ]);
    }

    /**
     * Retrieves all assessments.
     *
     * @return array The list of all assessments.
     */
    public function getAllAssessments(): array {
        return Assessment::all()->toArray();
    }

    /**
     * Retrieves an assessment by its ID.
     *
     * @param int $id The ID of the assessment to retrieve.
     * @return Assessment The retrieved assessment entity.
     */
    public function getAssessmentById(int $id): Assessment {
        $assessment = Assessment::find($id);
        if (!$assessment) {
            throw new \RuntimeException("Assessment not found with ID: $id");
        }
        return $assessment;
    }

    /**
     * Updates an existing assessment.
     *
     * @param int $id The ID of the assessment to update.
     * @param array $data The data for updating the assessment.
     * @return Assessment The updated assessment entity.
     */
    public function updateAssessment(int $id, array $data): Assessment {
        $assessment = Assessment::find($id);
        if (!$assessment) {
            throw new \RuntimeException("Assessment not found with ID: $id");
        }
        $assessment->update([
            'Activated' => $data['Activated'],
            'GameInstanceId' => $data['GameInstanceId'],
            'UserId' => $data['UserId'],
            'Value' => $data['Value'],
            'Comments' => $data['Comments'],
        ]);
        return $assessment;
    }

    public function deleteAssessment(int $id): Assessment {
        $assessment = Assessment::findOrFail($id);
        $assessment->Activated = false;
        $assessment->save();
        return $assessment;
    }
}