<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\GameInstancesDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\GameInstances\CreateGameInstanceUseCase;
use App\Application\UseCase\GameInstances\DeleteGameInstanceUseCase;
use App\Application\UseCase\GameInstances\GetAllGameInstancesUseCase;
use App\Application\UseCase\GameInstances\GetAllGameUseCase;
use App\Application\UseCase\GameInstances\GetGameInstanceByIdUseCase;
use App\Application\UseCase\GameInstances\UpdateGameInstanceUseCase;
use App\Infrastructure\Http\Requests\StoreGameInstancesRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="GameInstances",
 *     description="Operations related to game instances"
 * )
 */
class GameInstancesController extends Controller {
    use ApiResponse;
    private CreateGameInstanceUseCase $createGameInstanceUseCase;
    private GetAllGameInstancesUseCase $getAllGameInstancesUseCase;
    private GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase;
    private UpdateGameInstanceUseCase $updateGameInstanceUseCase;
    private DeleteGameInstanceUseCase $deleteGameInstanceUseCase;
    private GetAllGameUseCase $getAllGameUseCase;

    public function __construct(
        CreateGameInstanceUseCase $createGameInstanceUseCase,
        GetAllGameInstancesUseCase $getAllGameInstancesUseCase,
        GetAllGameUseCase $getAllGameUseCase,
        GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase,
        UpdateGameInstanceUseCase $updateGameInstanceUseCase,
        DeleteGameInstanceUseCase $deleteGameInstanceUseCase
    ) {
        $this->createGameInstanceUseCase = $createGameInstanceUseCase;
        $this->getAllGameInstancesUseCase = $getAllGameInstancesUseCase;
        $this->getAllGameUseCase = $getAllGameUseCase;
        $this->getGameInstanceByIdUseCase = $getGameInstanceByIdUseCase;
        $this->updateGameInstanceUseCase = $updateGameInstanceUseCase;
        $this->deleteGameInstanceUseCase = $deleteGameInstanceUseCase;
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
    public function getAllGameInstances() {
        $gameInstances = $this->getAllGameInstancesUseCase->execute();
        if (empty($gameInstances)) {
            return $this->errorResponse(2200);
        }
        return $this->successResponse($gameInstances, 2201);
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
    public function getAllGame() {
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
    public function getGameInstanceById($id) {
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
    public function createGameInstance(StoreGameInstancesRequest $request) {
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
    public function updateGameInstance($id, StoreGameInstancesRequest $request) {
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
    public function deleteGameInstance($id) {
        $gameInstance = $this->deleteGameInstanceUseCase->execute($id);
        if (empty($gameInstance)) {
            return $this->errorResponse(2208);
        }
        return $this->successResponse($gameInstance, 2209);
    }
}