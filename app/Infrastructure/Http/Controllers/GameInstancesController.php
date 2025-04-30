<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\GameInstancesDTO;
use App\Application\UseCase\GameInstances\CreateGameInstanceUseCase;
use App\Application\UseCase\GameInstances\DeleteGameInstanceUseCase;
use App\Application\UseCase\GameInstances\GetAllGameInstancesUseCase;
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
    private CreateGameInstanceUseCase $createGameInstanceUseCase;
    private GetAllGameInstancesUseCase $getAllGameInstancesUseCase;
    private GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase;
    private UpdateGameInstanceUseCase $updateGameInstanceUseCase;
    private DeleteGameInstanceUseCase $deleteGameInstanceUseCase;

    public function __construct(
        CreateGameInstanceUseCase $createGameInstanceUseCase,
        GetAllGameInstancesUseCase $getAllGameInstancesUseCase,
        GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase,
        UpdateGameInstanceUseCase $updateGameInstanceUseCase,
        DeleteGameInstanceUseCase $deleteGameInstanceUseCase
    ) {
        $this->createGameInstanceUseCase = $createGameInstanceUseCase;
        $this->getAllGameInstancesUseCase = $getAllGameInstancesUseCase;
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
            return response()->json(['message' => 'No game instances found'], 404);
        }
        return response()->json($gameInstances, 200);
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
            return response()->json(['message' => 'Game instance not found'], 404);
        }
        return response()->json($gameInstance, 200);
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
        return response()->json($gameInstance, 201);
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
        return response()->json($gameInstance, 200);
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
        return response()->json($gameInstance, 200);
    }
}