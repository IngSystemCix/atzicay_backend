<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\UseCase\Assessment\CreateAssessmentUseCase;
use Illuminate\Routing\Controller;

class AssessmentController extends Controller
{
    private CreateAssessmentUseCase $createAssessmentUseCase;

    public function __construct(CreateAssessmentUseCase $createAssessmentUseCase)
    {
        $this->createAssessmentUseCase = $createAssessmentUseCase;
    }

    public function createAssessment()
    {
        $data = request()->all();

        $dto = new \App\Application\DTOs\Assessment\CreateAssessmentDTO(
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
