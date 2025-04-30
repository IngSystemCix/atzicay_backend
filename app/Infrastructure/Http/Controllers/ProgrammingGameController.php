<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\ProgrammingGameDto;
use App\Application\UseCase\ProgrammingGame\CreateProgrammingGameUseCase;
use App\Application\UseCase\ProgrammingGame\DeleteProgrammingGameUseCase;
use App\Application\UseCase\ProgrammingGame\GetAllProgrammingGamesUseCase;
use App\Application\UseCase\ProgrammingGame\GetProgrammingGameByIdUseCase;
use App\Application\UseCase\ProgrammingGame\UpdateProgrammingGameUseCase;
use App\Infrastructure\Http\Requests\StoreProgrammingGameRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="ProgrammingGames",
 *     description="Operations related to programming games"
 * )
 */
class ProgrammingGameController extends Controller {
    private CreateProgrammingGameUseCase $createProgrammingGameUseCase;
    private GetAllProgrammingGamesUseCase $getAllProgrammingGamesUseCase;
    private GetProgrammingGameByIdUseCase $getProgrammingGameByIdUseCase;
    private UpdateProgrammingGameUseCase $updateProgrammingGameUseCase;
    private DeleteProgrammingGameUseCase $deleteProgrammingGameUseCase;

    public function __construct(
        CreateProgrammingGameUseCase $createProgrammingGameUseCase,
        GetAllProgrammingGamesUseCase $getAllProgrammingGamesUseCase,
        GetProgrammingGameByIdUseCase $getProgrammingGameByIdUseCase,
        UpdateProgrammingGameUseCase $updateProgrammingGameUseCase,
        DeleteProgrammingGameUseCase $deleteProgrammingGameUseCase
    ) {
        $this->createProgrammingGameUseCase = $createProgrammingGameUseCase;
        $this->getAllProgrammingGamesUseCase = $getAllProgrammingGamesUseCase;
        $this->getProgrammingGameByIdUseCase = $getProgrammingGameByIdUseCase;
        $this->updateProgrammingGameUseCase = $updateProgrammingGameUseCase;
        $this->deleteProgrammingGameUseCase = $deleteProgrammingGameUseCase;
    }

    /**
     * @OA\Get(
     *     path="/atzicay/v1/programming-games",
     *     tags={"ProgrammingGames"},
     *     summary="Get all programming games",
     *     description="Retrieves all programming games.",
     *     @OA\Response(
     *         response=200,
     *         description="List of programming games",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ProgrammingGameDTO"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No programming games found"
     *     ),
     * )
     */
    public function getAllProgrammingGames() {
        $programmingGames = $this->getAllProgrammingGamesUseCase->execute();
        if (empty($programmingGames)) {
            return response()->json(['message' => 'No programming games found'], 404);
        }
        return response()->json($programmingGames, 200);
    }

    /**
     * @OA\Get(
     *     path="/atzicay/v1/programming-games/{id}",
     *     tags={"ProgrammingGames"},
     *     summary="Get programming game by ID",
     *     description="Retrieves a programming game by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the programming game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Programming game details",
     *         @OA\JsonContent(ref="#/components/schemas/ProgrammingGameDTO")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Programming game not found"
     *     ),
     * )
     */
    public function getProgrammingGameById(int $id) {
        $programmingGame = $this->getProgrammingGameByIdUseCase->execute($id);
        if (empty($programmingGame)) {
            return response()->json(['message' => 'Programming game not found'], 404);
        }
        return response()->json($programmingGame, 200);
    }
    
    /**
     * @OA\Post(
     *     path="/atzicay/v1/programming-games",
     *     tags={"ProgrammingGames"},
     *     summary="Create a new programming game",
     *     description="Creates a new programming game.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProgrammingGameDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Programming game created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ProgrammingGame")
     *     ),
     * )
     */
    public function createProgrammingGame(StoreProgrammingGameRequest $request) {
        $validatedData = $request->validated();
        $programmingGameDto = new ProgrammingGameDto($validatedData);
        $programmingGame = $this->createProgrammingGameUseCase->execute($programmingGameDto);
        return response()->json($programmingGame, 201);
    }

    /**
     * @OA\Put(
     *     path="/atzicay/v1/programming-games/{id}",
     *     tags={"ProgrammingGames"},
     *     summary="Update a programming game",
     *     description="Updates an existing programming game.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the programming game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/ProgrammingGameDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Programming game updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/ProgrammingGame")
     *     ),
     * )
     */
    public function updateProgrammingGame($id, StoreProgrammingGameRequest $request) {
        $validatedData = $request->validated();
        $programmingGameDto = new ProgrammingGameDto($validatedData);
        $programmingGame = $this->updateProgrammingGameUseCase->execute($id, $programmingGameDto);
        return response()->json($programmingGame, 200);
    }

    /**
     * @OA\Delete(
     *     path="/atzicay/v1/programming-games/{id}",
     *     tags={"ProgrammingGames"},
     *     summary="Delete a programming game",
     *     description="Deletes a programming game by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the programming game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Programming game deleted successfully"
     *     ),
     * )
     */
    public function deleteProgrammingGame($id) {
        $programmingGame = $this->deleteProgrammingGameUseCase->execute($id);
        if (empty($programmingGame)) {
            return response()->json(['message' => 'Programming game not found'], 404);
        }
        return response()->json(['message' => 'Programming game deleted successfully'], 200);
    }
}