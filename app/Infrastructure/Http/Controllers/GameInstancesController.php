<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\GameInstancesDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\GameInstances\CreateGameInstanceUseCase;
use App\Application\UseCase\GameInstances\DeleteGameInstanceUseCase;
use App\Application\UseCase\GameInstances\GetAllGameInstancesUseCase;
use App\Application\UseCase\GameInstances\GetAllGameUseCase;
use App\Application\UseCase\GameInstances\GetGameInstanceByIdUseCase;
use App\Application\UseCase\GameInstances\SearchUseCase;
use App\Application\UseCase\GameInstances\UpdateGameInstanceUseCase;
use App\Infrastructure\Http\Requests\StoreGameInstancesRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="GameInstances",
 *     description="Operations related to game instances"
 * )
 */
class GameInstancesController extends Controller
{
    use ApiResponse;
    private CreateGameInstanceUseCase $createGameInstanceUseCase;
    private GetAllGameInstancesUseCase $getAllGameInstancesUseCase;
    private GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase;
    private UpdateGameInstanceUseCase $updateGameInstanceUseCase;
    private DeleteGameInstanceUseCase $deleteGameInstanceUseCase;
    private GetAllGameUseCase $getAllGameUseCase;
    private SearchUseCase $searchUseCase;

    public function __construct(
        CreateGameInstanceUseCase $createGameInstanceUseCase,
        GetAllGameInstancesUseCase $getAllGameInstancesUseCase,
        GetAllGameUseCase $getAllGameUseCase,
        GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase,
        UpdateGameInstanceUseCase $updateGameInstanceUseCase,
        DeleteGameInstanceUseCase $deleteGameInstanceUseCase,
        SearchUseCase $searchUseCase
    ) {
        $this->createGameInstanceUseCase = $createGameInstanceUseCase;
        $this->getAllGameInstancesUseCase = $getAllGameInstancesUseCase;
        $this->getAllGameUseCase = $getAllGameUseCase;
        $this->getGameInstanceByIdUseCase = $getGameInstanceByIdUseCase;
        $this->updateGameInstanceUseCase = $updateGameInstanceUseCase;
        $this->deleteGameInstanceUseCase = $deleteGameInstanceUseCase;
        $this->searchUseCase = $searchUseCase;
    }

    /**
     * @OA\Get(
     *     path="/game-instances",
     *     tags={"GameInstances"},
     *     summary="Get all game instances",
     *     description="Retrieves all game instances.",
     *     @OA\Response(
     *         response=200,
     *         description="List of game instances",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/GameInstances"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No game instances found"
     *     ),
     * )
     */
    public function getAllGameInstances()
    {
        $gameInstances = $this->getAllGameInstancesUseCase->execute();
        if (empty($gameInstances)) {
            return $this->errorResponse(2200);
        }
        return $this->successResponse($gameInstances, 2201);
    }

    /**
     * @OA\Get(
     *     path="/game-instances/search",
     *     summary="Buscar game instances",
     *     operationId="searchGameInstances",
     *     tags={"GameInstances"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nombre del game instance",
     *         required=false,
     *         @OA\Schema(type="string", maxLength=40)
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="ID del autor (professor_id)",
     *         required=false,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Tipo de juego (MEMORY_GAME, HANGMAN, PUZZLE, SOLVE_THE_WORD)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"MEMORY_GAME", "HANGMAN", "PUZZLE", "SOLVE_THE_WORD"})
     *     ),
     *     @OA\Parameter(
     *         name="difficulty",
     *         in="query",
     *         description="Dificultad (E=Easy, M=Medium, D=Difficult)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"E", "M", "D"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de game instances filtradas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/GameInstances")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron resultados",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=2212),
     *             @OA\Property(property="message", type="string", example="No se encontraron game instances")
     *         )
     *     )
     * )
     */
    public function searchGameInstances(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:40',
            'author' => 'nullable|integer|exists:users,id',
            'type' => 'nullable|string|in:MEMORY_GAME,HANGMAN,PUZZLE,SOLVE_THE_WORD',
            'difficulty' => 'nullable|in:E,M,D',
        ]);

        $gameInstances = $this->searchUseCase->execute($request);

        if (empty($gameInstances)) {
            return $this->errorResponse(2212);
        }

        return $this->successResponse($gameInstances, 2213);
    }


    /**
     * @OA\Get(
     *     path="/games",
     *     tags={"GameInstances"},
     *     summary="Get all games",
     *     description="Retrieves all games.",
     *     @OA\Response(
     *         response=200,
     *         description="List of games",
     *         @OA\JsonContent(type="array", @OA\Items(
     *             @OA\Property(property="id", type="integer"),
     *             @OA\Property(property="title", type="string"),
     *             @OA\Property(property="level", type="string"),
     *             @OA\Property(property="description", type="string"),
     *             @OA\Property(property="rating", type="integer"),
     *             @OA\Property(property="author", type="string")
     *         ))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No games found"
     *     ),
     * )
     */
    public function getAllGame()
    {
        $games = $this->getAllGameUseCase->execute();
        if (empty($games)) {
            return $this->errorResponse(2210);
        }
        return $this->successResponse($games, 2211);
    }

    /**
     * @OA\Get(
     *     path="/game-instances/{id}",
     *     tags={"GameInstances"},
     *     summary="Get game instance by ID",
     *     description="Retrieves a game instance by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance details",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game instance not found"
     *     ),
     * )
     */
    public function getGameInstanceById($id)
    {
        $gameInstance = $this->getGameInstanceByIdUseCase->execute($id);
        if (empty($gameInstance)) {
            return $this->errorResponse(2202);
        }
        return $this->successResponse($gameInstance, 2203);
    }

    /**
     * @OA\Post(
     *     path="/game-instances",
     *     tags={"GameInstances"},
     *     summary="Create a new game instance",
     *     description="Creates a new game instance.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameInstancesDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Game instance created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     * )
     */
    public function createGameInstance(StoreGameInstancesRequest $request)
    {
        $validatedData = $request->validated();
        $gameInstanceDto = new GameInstancesDTO($validatedData);
        $gameInstance = $this->createGameInstanceUseCase->execute($gameInstanceDto);
        return $this->successResponse($gameInstance, 2205);
    }

    /**
     * @OA\Put(
     *     path="/game-instances/{id}",
     *     tags={"GameInstances"},
     *     summary="Update a game instance",
     *     description="Updates an existing game instance.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameInstancesDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     * )
     */
    public function updateGameInstance($id, StoreGameInstancesRequest $request)
    {
        $validatedData = $request->validated();
        $gameInstanceDto = new GameInstancesDTO($validatedData);
        $gameInstance = $this->updateGameInstanceUseCase->execute($id, $gameInstanceDto);
        return $this->successResponse($gameInstance, 2207);
    }

    /**
     * @OA\Delete(
     *     path="/game-instances/{id}",
     *     tags={"GameInstances"},
     *     summary="Delete a game instance",
     *     description="Deletes a game instance by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     * )
     */
    public function deleteGameInstance($id)
    {
        $gameInstance = $this->deleteGameInstanceUseCase->execute($id);
        if (empty($gameInstance)) {
            return $this->errorResponse(2208);
        }
        return $this->successResponse($gameInstance, 2209);
    }
}