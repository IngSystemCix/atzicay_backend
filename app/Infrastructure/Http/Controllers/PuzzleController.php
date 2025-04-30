<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\PuzzleDTO;
use App\Application\UseCase\Puzzle\CreatePuzzleUseCase;
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
    private CreatePuzzleUseCase $createPuzzleUseCase;
    private GetPuzzleByIdUseCase $getPuzzleByIdUseCase;
    private UpdatePuzzleUseCase $updatePuzzleUseCase;

    public function __construct(
        CreatePuzzleUseCase $createPuzzleUseCase,
        GetPuzzleByIdUseCase $getPuzzleByIdUseCase,
        UpdatePuzzleUseCase $updatePuzzleUseCase
    ) {
        $this->createPuzzleUseCase = $createPuzzleUseCase;
        $this->getPuzzleByIdUseCase = $getPuzzleByIdUseCase;
        $this->updatePuzzleUseCase = $updatePuzzleUseCase;
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
            return response()->json(['message' => 'Puzzle not found'], 404);
        }
        return response()->json($puzzle, 200);
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
        return response()->json($puzzle, 201);
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
        return response()->json($puzzle, 200);
    }
}