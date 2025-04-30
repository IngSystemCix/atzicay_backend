<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Assessment;

/**
 * Interface for managing assessments in the repository.
 */
interface AssessmentRepository
{
    /**
     * Creates a new assessment.
     *
     * @param array $data The data for creating the assessment.
     * @return Assessment The created assessment entity.
     */
    public function createAssessment(array $data): Assessment;

    /**
     * Retrieves all assessments.
     *
     * @return array The list of all assessments.
     */
    public function getAllAssessments(): array;

    /**
     * Retrieves an assessment by its ID.
     *
     * @param int $id The ID of the assessment to retrieve.
     * @return Assessment The retrieved assessment entity.
     */
    public function getAssessmentById(int $id): Assessment;

    /**
     * Updates an existing assessment.
     *
     * @param int $id The ID of the assessment to update.
     * @param array $data The data for updating the assessment.
     * @return Assessment The updated assessment entity.
     */
    public function updateAssessment(int $id, array $data): Assessment;

    /**
     * Deletes an assessment by its ID.
     *
     * @param int $id The ID of the assessment to delete.
     * @return Assessment The deleted assessment entity.
     */
    public function deleteAssessment(int $id): Assessment;
}