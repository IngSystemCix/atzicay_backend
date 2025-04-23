<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\AssessmentDTO;
use App\Application\UseCase\Assessment\CreateAssessmentUseCase;
use Illuminate\Routing\Controller;

class AssessmentController extends Controller
{
    private CreateAssessmentUseCase $createAssessmentUseCase;

    public function __construct(CreateAssessmentUseCase $createAssessmentUseCase)
    {
        $this->createAssessmentUseCase = $createAssessmentUseCase;
    }

    /**
     * @OA\Post(
     *     path="/assessments",
     *     tags={"Assessments"},
     *     summary="Create a new assessment",
     *     description="Creates a new assessment.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *          required={"Activated", "GameInstanceId", "UserId", "Value"},
     *          @OA\Property(property="Activated", type="boolean", example=true),
     *          @OA\Property(property="GameInstanceId", type="integer", example=1),
     *          @OA\Property(property="UserId", type="integer", example=1),
     *          @OA\Property(property="Value", type="integer", example=5),
     *          @OA\Property(property="Comments", type="string", example="Great job!"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Assessment created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Assessment")
     *     ),
     *    @OA\Response(
     *       response=400,
     *      description="Invalid input"
     *    ),
     * )
     */
    public function createAssessment()
    {
        $data = request()->all();

        $dto = new AssessmentDTO(
            activated: $data['Activated'],
            gameInstanceId: $data['GameInstanceId'],
            userId: $data['UserId'],
            value: $data['Value'],
            comments: $data['Comments'] ?? null
        );

        $assessment = $this->createAssessmentUseCase->execute($dto);

        return response()->json($assessment, 201);
    }
}
