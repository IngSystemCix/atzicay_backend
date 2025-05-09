<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\GameSettingDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\GameSetting\CreateGameSettingUseCase;
use App\Application\UseCase\GameSetting\GetGameSettingByIdUseCase;
use App\Application\UseCase\GameSetting\UpdateGameSettingUseCase;
use App\Infrastructure\Http\Requests\StoreGameSettingRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="GameSettings",
 *     description="Operations related to game settings"
 * )
 */
class GameSettingController extends Controller {
    use ApiResponse;
    private CreateGameSettingUseCase $createGameSettingUseCase;
    private GetGameSettingByIdUseCase $getGameSettingByIdUseCase;
    private UpdateGameSettingUseCase $updateGameSettingUseCase;

    public function __construct(
        CreateGameSettingUseCase $createGameSettingUseCase,
        GetGameSettingByIdUseCase $getGameSettingByIdUseCase,
        UpdateGameSettingUseCase $updateGameSettingUseCase
    ) {
        $this->createGameSettingUseCase = $createGameSettingUseCase;
        $this->getGameSettingByIdUseCase = $getGameSettingByIdUseCase;
        $this->updateGameSettingUseCase = $updateGameSettingUseCase;
    }

    /**
     * @OA\Get(
     *     path="/game-settings/{id}",
     *     tags={"GameSettings"},
     *     summary="Get a game setting by ID",
     *     description="Retrieves a game setting by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the game setting to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game setting found",
     *         @OA\JsonContent(ref="#/components/schemas/GameSettingDTO")
     *     ),
     * )
     */
    public function getGameSettingById(int $id) {
        $gameSetting = $this->getGameSettingByIdUseCase->execute($id);
        if (!$gameSetting) {
            return $this->errorResponse(2501);
        }
        return $this->successResponse($gameSetting, 2500);
    }

    /**
     * @OA\Post(
     *     path="/game-settings",
     *     tags={"GameSettings"},
     *     summary="Create a new game setting",
     *     description="Creates a new game setting.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameSettingDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Game setting created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameSetting")
     *     ),
     * )
     */
    public function createGameSetting(StoreGameSettingRequest $request) {
        $validatedData = $request->validated();
        $gameSettingDTO = new GameSettingDTO($validatedData);
        $gameSetting = $this->createGameSettingUseCase->execute($gameSettingDTO);
        return $this->successResponse($gameSetting, 2503);
    }

    /**
     * @OA\Put(
     *     path="/game-settings/{id}",
     *     tags={"GameSettings"},
     *     summary="Update a game setting",
     *     description="Updates an existing game setting.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the game setting to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameSettingDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game setting updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameSetting")
     *     ),
     * )
     */
    public function updateGameSetting(int $id, StoreGameSettingRequest $request) {
        $validatedData = $request->validated();
        $gameSettingDTO = new GameSettingDTO($validatedData);
        $gameSetting = $this->updateGameSettingUseCase->execute($id, $gameSettingDTO);
        return $this->successResponse($gameSetting, 2506);
    }
}