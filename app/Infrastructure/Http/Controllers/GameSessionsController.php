<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\GameSessionsDTO;
use App\Application\UseCase\GameSessions\CreateGameSessionUseCase;
use App\Application\UseCase\GameSessions\GetGameSessionByIdUseCase;
use App\Application\UseCase\GameSessions\UpdateGameSessionUseCase;
use App\Infrastructure\Http\Requests\StoreGameSessionRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="GameSessions",
 *     description="Operations related to game sessions"
 * )
 */
class GameSessionsController extends Controller {
    private CreateGameSessionUseCase $createGameSessionUseCase;
    private GetGameSessionByIdUseCase $getGameSessionByIdUseCase;
    private UpdateGameSessionUseCase $updateGameSessionUseCase;

    public function __construct(
        CreateGameSessionUseCase $createGameSessionUseCase,
        GetGameSessionByIdUseCase $getGameSessionByIdUseCase,
        UpdateGameSessionUseCase $updateGameSessionUseCase
    ) {
        $this->createGameSessionUseCase = $createGameSessionUseCase;
        $this->getGameSessionByIdUseCase = $getGameSessionByIdUseCase;
        $this->updateGameSessionUseCase = $updateGameSessionUseCase;
    }

    /**
     * @OA\Get(
     *     path="/game-sessions/{id}",
     *     tags={"GameSessions"},
     *     summary="Get game session by ID",
     *     description="Retrieves a game session by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the game session",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game session details",
     *         @OA\JsonContent(ref="#/components/schemas/GameSession")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game session not found"
     *     ),
     * )
     */
    public function getGameSessionById($id) {
        $gameSession = $this->getGameSessionByIdUseCase->execute($id);
        if (empty($gameSession)) {
            return response()->json(['message' => 'Game session not found'], 404);
        }
        return response()->json($gameSession, 200);
    }

    /**
     * @OA\Post(
     *     path="/game-sessions",
     *     tags={"GameSessions"},
     *     summary="Create a new game session",
     *     description="Creates a new game session.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameSessionsDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Game session created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameSession")
     *     ),
     * )
     */
    public function createGameSession(StoreGameSessionRequest $request) {
        $validatedData = $request->validated();
        $gameSessionDTO = new GameSessionsDTO($validatedData);
        $gameSession = $this->createGameSessionUseCase->execute($gameSessionDTO);
        return response()->json($gameSession, 201);
    }

    /**
     * @OA\Put(
     *     path="/game-sessions/{id}",
     *     tags={"GameSessions"},
     *     summary="Update an existing game session",
     *     description="Updates an existing game session.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the game session",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameSessionsDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game session updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameSession")
     *     ),
     * )
     */
    public function updateGameSession($id, StoreGameSessionRequest $request) {
        $validatedData = $request->validated();
        $gameSessionDTO = new GameSessionsDTO($validatedData);
        $gameSession = $this->updateGameSessionUseCase->execute($id, $gameSessionDTO);
        return response()->json($gameSession, 200);
    }
}