<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\GameProgressDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\GameProgress\CreateGameProgressUseCase;
use App\Application\UseCase\GameProgress\GetGameProgressByIdUseCase;
use App\Application\UseCase\GameProgress\UpdateGameProgressUseCase;
use App\Infrastructure\Http\Requests\StoreGameProgressRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="GameProgress",
 *     description="GameProgress operations"
 * )
 */
class GameProgressController extends Controller {
    use ApiResponse;
    private CreateGameProgressUseCase $createGameProgressUseCase;
    private GetGameProgressByIdUseCase $getGameProgressByIdUseCase;
    private UpdateGameProgressUseCase $updateGameProgressUseCase;

    public function __construct(
        CreateGameProgressUseCase $createGameProgressUseCase,
        GetGameProgressByIdUseCase $getGameProgressByIdUseCase,
        UpdateGameProgressUseCase $updateGameProgressUseCase
    ) {
        $this->createGameProgressUseCase = $createGameProgressUseCase;
        $this->getGameProgressByIdUseCase = $getGameProgressByIdUseCase;
        $this->updateGameProgressUseCase = $updateGameProgressUseCase;
    }

    /**
     * @OA\Get(
     *     path="/game-progress/{id}",
     *     tags={"GameProgress"},
     *     summary="Get Game Progress by ID",
     *     description="Retrieves a Game Progress by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the Game Progress to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game Progress found",
     *         @OA\JsonContent(ref="#/components/schemas/GameProgress")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game Progress not found"
     *     ),
     * )
     */
    public function getGameProgressById($id) {
        $gameProgress = $this->getGameProgressByIdUseCase->execute($id);
        if (!$gameProgress) {
            return $this->errorResponse(3201);
        }
        return $this->successResponse($gameProgress, 3200);
    }

    /**
     * @OA\Post(
     *     path="/game-progress",
     *     tags={"GameProgress"},
     *     summary="Create Game Progress",
     *     description="Creates a new Game Progress.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameProgressDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Game Progress created",
     *         @OA\JsonContent(ref="#/components/schemas/GameProgress")
     *     ),
     * )
     */
    public function createGameProgress(StoreGameProgressRequest $request) {
        $validatedData = $request->validated();
        $gameProgressDTO = new GameProgressDTO($validatedData);
        $gameProgress = $this->createGameProgressUseCase->execute($gameProgressDTO);
        return $this->successResponse($gameProgress, 3203);
    }

    /**
     * @OA\Put(
     *     path="/game-progress/{id}",
     *     tags={"GameProgress"},
     *     summary="Update Game Progress",
     *     description="Updates an existing Game Progress.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the Game Progress to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameProgressDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game Progress updated",
     *         @OA\JsonContent(ref="#/components/schemas/GameProgress")
     *     ),
     * )
     */
    public function updateGameProgress($id, StoreGameProgressRequest $request) {
        $validatedData = $request->validated();
        $gameProgressDTO = new GameProgressDTO($validatedData);
        $gameProgress = $this->updateGameProgressUseCase->execute($id, $gameProgressDTO);
        return $this->successResponse($gameProgress, 3206);
    }
}