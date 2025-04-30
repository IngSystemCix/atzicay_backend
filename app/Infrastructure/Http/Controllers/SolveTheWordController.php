<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\SolveTheWordDTO;
use App\Application\UseCase\SolveTheWord\CreateSolveTheWordUseCase;
use App\Application\UseCase\SolveTheWord\GetSolveTheWordByIdUseCase;
use App\Application\UseCase\SolveTheWord\UpdateSolveTheWordUseCase;
use App\Infrastructure\Http\Requests\StoreSolveTheWordRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="SolveTheWord",
 *     description="SolveTheWord operations"
 * )
 */
class SolveTheWordController extends Controller {
    private CreateSolveTheWordUseCase $createSolveTheWordUseCase;
    private GetSolveTheWordByIdUseCase $getSolveTheWordByIdUseCase;
    private UpdateSolveTheWordUseCase $updateSolveTheWordUseCase;

    public function __construct(
        CreateSolveTheWordUseCase $createSolveTheWordUseCase,
        GetSolveTheWordByIdUseCase $getSolveTheWordByIdUseCase,
        UpdateSolveTheWordUseCase $updateSolveTheWordUseCase
    ) {
        $this->createSolveTheWordUseCase = $createSolveTheWordUseCase;
        $this->getSolveTheWordByIdUseCase = $getSolveTheWordByIdUseCase;
        $this->updateSolveTheWordUseCase = $updateSolveTheWordUseCase;
    }

    /**
     * @OA\Get(
     *     path="/solve-the-word/{id}",
     *     tags={"SolveTheWord"},
     *     summary="Get SolveTheWord by ID",
     *     description="Retrieves a SolveTheWord by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the SolveTheWord to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="SolveTheWord found",
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWord")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="SolveTheWord not found"
     *     ),
     * )
     */
    public function getSolveTheWordById($id) {
        $solveTheWord = $this->getSolveTheWordByIdUseCase->execute($id);
        if (!$solveTheWord) {
            return response()->json(['message' => 'SolveTheWord not found'], 404);
        }
        return response()->json($solveTheWord, 200);
    }

    /**
     * @OA\Post(
     *     path="/solve-the-word",
     *     tags={"SolveTheWord"},
     *     summary="Create a new SolveTheWord",
     *     description="Creates a new SolveTheWord.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWordDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="SolveTheWord created",
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWord")
     *     ),
     * )
     */
    public function createSolveTheWord(StoreSolveTheWordRequest $request) {
        $validatedData = $request->validated();
        $solveTheWordDTO = new SolveTheWordDTO($validatedData);
        $solveTheWord = $this->createSolveTheWordUseCase->execute($solveTheWordDTO);
        return response()->json($solveTheWord, 201);
    }

    /**
     * @OA\Put(
     *     path="/solve-the-word/{id}",
     *     tags={"SolveTheWord"},
     *     summary="Update an existing SolveTheWord",
     *     description="Updates an existing SolveTheWord.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the SolveTheWord to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWordDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="SolveTheWord updated",
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWord")
     *     ),
     * )
     */
    public function updateSolveTheWord($id, StoreSolveTheWordRequest $request) {
        $validatedData = $request->validated();
        $solveTheWordDTO = new SolveTheWordDTO($validatedData);
        $solveTheWord = $this->updateSolveTheWordUseCase->execute($id, $solveTheWordDTO);
        return response()->json($solveTheWord, 200);
    }
}