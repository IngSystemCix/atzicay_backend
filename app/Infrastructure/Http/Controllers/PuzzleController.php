<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\PuzzleDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\Puzzle\CreatePuzzleUseCase;
use App\Application\UseCase\Puzzle\GetAllPuzzlesUseCase;
use App\Application\UseCase\Puzzle\GetPuzzleByIdUseCase;
use App\Application\UseCase\Puzzle\UpdatePuzzleUseCase;
use App\Infrastructure\Http\Requests\StorePuzzleRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Puzzles",
 *     description="Operations related to puzzles"
 * )
 */
class PuzzleController extends Controller {
    use ApiResponse;
    private CreatePuzzleUseCase $createPuzzleUseCase;
    private GetPuzzleByIdUseCase $getPuzzleByIdUseCase;
    private UpdatePuzzleUseCase $updatePuzzleUseCase;
    private GetAllPuzzlesUseCase $getAllPuzzlesUseCase;

    public function __construct(
        CreatePuzzleUseCase $createPuzzleUseCase,
        GetPuzzleByIdUseCase $getPuzzleByIdUseCase,
        UpdatePuzzleUseCase $updatePuzzleUseCase,
        GetAllPuzzlesUseCase $getAllPuzzlesUseCase
    ) {
        $this->createPuzzleUseCase = $createPuzzleUseCase;
        $this->getPuzzleByIdUseCase = $getPuzzleByIdUseCase;
        $this->updatePuzzleUseCase = $updatePuzzleUseCase;
        $this->getAllPuzzlesUseCase = $getAllPuzzlesUseCase;
    }

    /**
     * @OA\Get(
     *     path="/puzzles",
     *     tags={"Puzzles"},
     *     summary="Get all puzzles",
     *     description="Retrieves all puzzles.",
     *     @OA\Response(
     *         response=200,
     *         description="List of puzzles",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Puzzle"))
     *     ),
     * )
     */
    public function getAllPuzzles() {
        $puzzles = $this->getAllPuzzlesUseCase->execute();
        if (!$puzzles) {
            return $this->errorResponse(2911);
        }
        return $this->successResponse($puzzles, 2910);
    }

    /**
     * @OA\Get(
     *     path="/puzzles/{id}",
     *     tags={"Puzzles"},
     *     summary="Get puzzle by ID",
     *     description="Retrieves a puzzle by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the puzzle to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Puzzle found",
     *         @OA\JsonContent(ref="#/components/schemas/Puzzle")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Puzzle not found"
     *     ),
     * )
     */
    public function getPuzzleById(int $id) {
        $puzzle = $this->getPuzzleByIdUseCase->execute($id);
        if (!$puzzle) {
            return $this->errorResponse(2901);
        }
        return $this->successResponse($puzzle, 2900);
    }

    /**
     * @OA\Post(
     *     path="/puzzles",
     *     tags={"Puzzles"},
     *     summary="Create a new puzzle",
     *     description="Creates a new puzzle.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PuzzleDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Puzzle created",
     *         @OA\JsonContent(ref="#/components/schemas/Puzzle")
     *     ),
     * )
     */
    public function createPuzzle(StorePuzzleRequest $request) {
        $validatedData = $request->validated();
        $puzzleDTO = new PuzzleDTO($validatedData);
        $puzzle = $this->createPuzzleUseCase->execute($puzzleDTO);
        return $this->successResponse($puzzle, 2903);
    }

    /**
     * @OA\Put(
     *     path="/puzzles/{id}",
     *     tags={"Puzzles"},
     *     summary="Update an existing puzzle",
     *     description="Updates an existing puzzle.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the puzzle to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PuzzleDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Puzzle updated",
     *         @OA\JsonContent(ref="#/components/schemas/Puzzle")
     *     ),
     * )
     */
    public function updatePuzzle($id, StorePuzzleRequest $request) {
        $validatedData = $request->validated();
        $puzzleDTO = new PuzzleDTO($validatedData);
        $puzzle = $this->updatePuzzleUseCase->execute($id, $puzzleDTO);
        return $this->successResponse($puzzle, 2906);
    }
}