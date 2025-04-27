<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\AssessmentDTO;
use App\Application\UseCase\Assessment\CreateAssessmentUseCase;
use App\Application\UseCase\Assessment\GetAllAssessmentsUseCase;
use App\Application\UseCase\Assessment\GetAssessmentByIdUseCase;
use App\Application\UseCase\Assessment\UpdateAssessmentUseCase;
use App\Infrastructure\Http\Requests\StoreAssessmentRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Assessments",
 *     description="Operations related to assessments"
 * )
 */
class AssessmentController extends Controller
{
    private CreateAssessmentUseCase $createAssessmentUseCase;
    private GetAllAssessmentsUseCase $getAllAssessmentsUseCase;
    private GetAssessmentByIdUseCase $getAssessmentByIdUseCase;
    private UpdateAssessmentUseCase $updateAssessmentUseCase;

    public function __construct(
        CreateAssessmentUseCase $createAssessmentUseCase,
        GetAllAssessmentsUseCase $getAllAssessmentsUseCase,
        GetAssessmentByIdUseCase $getAssessmentByIdUseCase,
        UpdateAssessmentUseCase $updateAssessmentUseCase
    ) {
        $this->createAssessmentUseCase = $createAssessmentUseCase;
        $this->getAllAssessmentsUseCase = $getAllAssessmentsUseCase;
        $this->getAssessmentByIdUseCase = $getAssessmentByIdUseCase;
        $this->updateAssessmentUseCase = $updateAssessmentUseCase;
    }

    /**
     * @OA\Get(
     *     path="/assessments",
     *     tags={"Assessments"},
     *     summary="Get all assessments",
     *     description="Retrieves all assessments.",
     *     @OA\Response(
     *         response=200,
     *         description="List of assessments",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Assessment"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No assessments found"
     *     ),
     * )
     */
    public function getAllAssessments()
    {
        $assessments = $this->getAllAssessmentsUseCase->execute();
        if (empty($assessments)) {
            return response()->json(['message' => 'No assessments found'], 404);
        }
        return response()->json($assessments, 200);
    }


    /**
     * @OA\Get(
     *     path="/assessments/{id}",
     *     tags={"Assessments"},
     *     summary="Get assessment by ID",
     *     description="Retrieves an assessment by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the assessment to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assessment found",
     *         @OA\JsonContent(ref="#/components/schemas/Assessment")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assessment not found"
     *     ),
     * )
     */
    public function getAssessmentsById(int $id)
    {
        $assessment = $this->getAssessmentByIdUseCase->execute($id);
        if (!$assessment) {
            return response()->json(['message' => 'Assessment not found'], 404);
        }
        return response()->json($assessment, 200);
    }

    /**
     * @OA\Post(
     *     path="/assessments",
     *     tags={"Assessments"},
     *     summary="Create a new assessment",
     *     description="Creates a new assessment.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AssessmentDTO")
     *      ),
     *      @OA\Response(
     *         response=201,
     *         description="Assessment created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Assessment")
     *      ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid input"
     *      ),
     * )
     */
    public function createAssessment(StoreAssessmentRequest $request)
    {
        $data = $request->all();
        $dto = new AssessmentDTO(
            $data['Activated'],
            $data['GameInstanceId'],
            $data['UserId'],
            $data['Value'],
            $data['Comments'] ?? ''
        );
        try {
            $assessment = $this->createAssessmentUseCase->execute($dto);
            return response()->json($assessment, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid input'], 400);
        }
    }

    /**
     * @OA\Put(
     *     path="/assessments/{id}",
     *     tags={"Assessments"},
     *     summary="Update an assessment",
     *     description="Updates an existing assessment.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the assessment to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/AssessmentDTO")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Assessment updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Assessment")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Assessment not found"
     *      ),
     * )
     */
    public function updateAssessment(StoreAssessmentRequest $request, int $id)
    {
        $data = $request->all();
        $dto = new AssessmentDTO(
            $data['Activated'],
            $data['GameInstanceId'],
            $data['UserId'],
            $data['Value'],
            $data['Comments'] ?? ''
        );
        try {
            $assessment = $this->updateAssessmentUseCase->execute(id: $id, data: $dto);
            return response()->json($assessment, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Invalid input'], 400);
        }
    }
}
