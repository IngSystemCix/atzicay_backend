<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\MemoryGameDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\MemoryGame\createMemoryGameUseCase;
use App\Application\UseCase\MemoryGame\GetMemoryGameByIdUseCase;
use App\Application\UseCase\MemoryGame\UpdateMemoryGameUseCase;
use App\Infrastructure\Http\Requests\StoreMemoryGameRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="MemoryGame",
 *     description="Operations related to Memory Game"
 * )
 */
class MemoryGameController extends Controller {
    use ApiResponse;
    private createMemoryGameUseCase $createMemoryGameUseCase;
    private GetMemoryGameByIdUseCase $getMemoryGameByIdUseCase;
    private UpdateMemoryGameUseCase $updateMemoryGameUseCase;

    public function __construct(
        createMemoryGameUseCase $createMemoryGameUseCase,
        GetMemoryGameByIdUseCase $getMemoryGameByIdUseCase,
        UpdateMemoryGameUseCase $updateMemoryGameUseCase
    ) {
        $this->createMemoryGameUseCase = $createMemoryGameUseCase;
        $this->getMemoryGameByIdUseCase = $getMemoryGameByIdUseCase;
        $this->updateMemoryGameUseCase = $updateMemoryGameUseCase;
    }

    /**
     * @OA\Get(
     *     path="/memory-game/{id}",
     *     tags={"MemoryGame"},
     *     summary="Get Memory Game by ID",
     *     description="Retrieves a memory game by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the memory game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Memory game found",
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGame")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Memory game not found"
     *     )
     * )
     */
    public function getMemoryGameById(int $id) {
        $memoryGame = $this->getMemoryGameByIdUseCase->execute($id);
        if (!$memoryGame) {
            return $this->errorResponse(2801);
        }
        return $this->successResponse($memoryGame, 2800);
    }

    /**
     * @OA\Post(
     *     path="/memory-game",
     *     tags={"MemoryGame"},
     *     summary="Create a new Memory Game",
     *     description="Creates a new memory game.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGameDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Memory game created",
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGame")
     *     )
     * )
     */
    public function createMemoryGame(StoreMemoryGameRequest $request) {
        $validatedData = $request->validated();
        $memoryGameDTO = new MemoryGameDTO($validatedData);
        $memoryGame = $this->createMemoryGameUseCase->execute($memoryGameDTO);
        return $this->successResponse($memoryGame, 2803);
    }

    /**
     * @OA\Put(
     *     path="/memory-game/{id}",
     *     tags={"MemoryGame"},
     *     summary="Update Memory Game by ID",
     *     description="Updates a memory game by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the memory game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGameDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Memory game updated",
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGame")
     *     ),
     * )
     */
    public function updateMemoryGame($id, StoreMemoryGameRequest $request) {
        $validatedData = $request->validated();
        $memoryGameDTO = new MemoryGameDTO($validatedData);
        $memoryGame = $this->updateMemoryGameUseCase->execute($id, $memoryGameDTO);
        return $this->successResponse($memoryGame, 2806);
    }
}