<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\PuzzleDTO;
use App\Application\UseCase\Puzzle\CreatePuzzleUseCase;
use App\Application\UseCase\Puzzle\DeletePuzzleUseCase;
use App\Application\UseCase\Puzzle\GetAllPuzzleUseCase;
use App\Application\UseCase\Puzzle\GetPuzzleByIdUseCase;
use App\Application\UseCase\Puzzle\UpdatePuzzleUseCase;
use App\Infrastructure\Http\Requests\StorePuzzleRequest;

/**
 * @OA\Tag(
 *     name="Puzzle",
 *     description="Operations related to Puzzle"
 * )
 */

 class PuzzleController extends Controller
 {
    private CreatePuzzleUseCase $createPuzzleUseCase;
    private GetPuzzleByIdUseCase $getPuzzleByIdUseCase;
    private GetAllPuzzleUseCase $getAllPuzzleUseCase;
    private UpdatePuzzleUseCase $updatePuzzleUseCase;
    private DeletePuzzleUseCase $deletePuzzleUseCase;
    public function __construct(
        CreatePuzzleUseCase $createPuzzleUseCase,
        GetPuzzleByIdUseCase $getPuzzleByIdUseCase,
        GetAllPuzzleUseCase $getAllPuzzleUseCase,
        UpdatePuzzleUseCase $updatePuzzleUseCase,
        DeletePuzzleUseCase $deletePuzzleUseCase
    ) {
        $this->createPuzzleUseCase = $createPuzzleUseCase;
        $this->getPuzzleByIdUseCase = $getPuzzleByIdUseCase;
        $this->getAllPuzzleUseCase = $getAllPuzzleUseCase;
        $this->updatePuzzleUseCase = $updatePuzzleUseCase;
        $this->deletePuzzleUseCase = $deletePuzzleUseCase;
    }

    /**
     * @OA\Post(
     *     path="/puzzle",
     *     tags={"Puzzle"},
     *     summary="Create a new Puzzle",
     *     description="Creates a new Puzzle.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *          required={"GameInstanceId", "PathImg", "Clue", "Rows", "Cols", "AutomaticHelp"},
     *          @OA\Property(property="GameInstanceId", type="integer", example=1),
     *          @OA\Property(property="PathImg", type="string", example="MacchuPicchu.png"),
     *          @OA\Property(property="Clue", type="String", example="Wonder of the world"),
     *          @OA\Property(property="Rows", type="integer", example=6
     *          @OA\Property(property="Cols", type="integer", example=6
     *          @OA\Property(property="AutomaticHelp", type="integer", example=0
     *         ),
     *         ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Correctly passed the Puzzle's game",
     *         @OA\JsonContent(ref="#/components/schemas/Puzzle")
     *     ),
     *    @OA\Response(
     *       response=400,
     *      description="Invalid input"
     *    ),
     * )
     */
    public function createPuzzle(StorePuzzleRequest $request)
    {
        $data = $request->All();
        $dto = new PuzzleDTO(
            $data["GameInstanceId"],
            $data["PathImg"],
            $data["Clue"],
            $data["Rows"],
            $data["Cols"],
            $data["AutomaticHelp"],
        );
        try {
            $puzzle = $this->createPuzzleUseCase->execute($dto);
            return response()->json($puzzle,201);
        }catch (\Exception $e) {
            return response()->json(['message'=>'Invalid input'],400);
        }
    }

    /**
     * @OA\Get(
     *     path="/puzzle",
     *     tags={"Puzzle"},
     *     summary="Get all puzzles",
     *     description="Retrieves all puzzles.",
     *     @OA\Response(
     *         response=200,
     *         description="List of puzzles",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Puzzle"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No puzzles found"
     *     ),
     * )
     */
    public function getAllPuzzle(){
        $puzzle = $this->getAllPuzzle->execute();
        if(!$puzzle){
            return response()->json(['message'=> 'No puzzle found'],404);
        }
        return response()->json($puzzle,200);
    }

    /**
     * @OA\Get(
     *     path="/puzzle/{id}",
     *     tags={"Puzzle"},
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
    public function getPuzzleById(int $id)
    {
        $puzzle = $this->getPuzzleByIdUseCase->execute($id);
        if(!$puzzle){
            return response()->json(['message'=> 'Puzzle not found'],404);
        }
        return response()->json($puzzle,200);
    }

    /**
     * @OA\Put(
     *     path="/puzzle/{id}",
     *     tags={"puzzle"},
     *     summary="Update a puzzle",
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
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Puzzle updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Puzzle")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Puzzle not found"
     *      ),
     * )
     */
    public function updatePuzzle(StorePuzzleRequest $request, int $id)
    {
        $data = $request->All();
        $dto = new PuzzleDTO(
            $data['GameInstaId'],
            $data['PathImg'],
            $data['Clue'],
            $data['Rows'],
            $data['Cols'],
            $data['AutomaticHelp'],
        );
        try {
            $puzzle = $this->updatePuzzleUseCase->execute($id, $data);
            return response()->json($puzzle,200);
        }catch (\Exception $e) {
            return response()->json(['message'=> 'Invalid input'],400);
        }
    }

    /**
     * @OA\Put(
     *     path="/puzzle/{id}",
     *     tags={"puzzle"},
     *     summary="Update a puzzle",
     *     description="Delete an existing puzzle.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the puzzle to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/PuzzleDTO")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Puzzle deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Puzzle")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Puzzle not found"
     *      ),
     * )
     */
    public function deletePuzzle(int $id){
        try {
            $this->getPuzzleByIdUseCase->execute($id);
            $this->deletePuzzleUseCase->execute($id);
            return response()->json(['message'=> 'Puzzle deleted successfully'],200);
        }catch (\Exception $e) {
            return response()->json(['message'=> 'Invalid input'],400);
        }
    }
 }