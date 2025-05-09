<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\HangmanDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\Hangman\CreateHangmanUseCase;
use App\Application\UseCase\Hangman\GetAllHangmanUseCase;
use App\Application\UseCase\Hangman\GetHangmanByIdUseCase;
use App\Application\UseCase\Hangman\UpdateHangmanUseCase;
use App\Infrastructure\Http\Requests\StoreHangmanRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Hangman",
 *     description="Operations related to hangman game"
 * )
 */
class HangmanController extends Controller {
    use ApiResponse;
    private CreateHangmanUseCase $createHangmanUseCase;
    private GetAllHangmanUseCase $getAllHangmanUseCase;
    private GetHangmanByIdUseCase $getHangmanByIdUseCase;
    private UpdateHangmanUseCase $updateHangmanUseCase;

    public function __construct(
        CreateHangmanUseCase $createHangmanUseCase,
        GetAllHangmanUseCase $getAllHangmanUseCase,
        GetHangmanByIdUseCase $getHangmanByIdUseCase,
        UpdateHangmanUseCase $updateHangmanUseCase
    ) {
        $this->createHangmanUseCase = $createHangmanUseCase;
        $this->getAllHangmanUseCase = $getAllHangmanUseCase;
        $this->getHangmanByIdUseCase = $getHangmanByIdUseCase;
        $this->updateHangmanUseCase = $updateHangmanUseCase;
    }

    /**
     * @OA\Get(
     *     path="/hangman",
     *     tags={"Hangman"},
     *     summary="Get all hangman games",
     *     description="Retrieves all hangman games.",
     *     @OA\Response(
     *         response=200,
     *         description="List of hangman games",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Hangman"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hangman games found"
     *     ),
     * )
     */
    public function getAllHangman() {
        $hangman = $this->getAllHangmanUseCase->execute();
        if (empty($hangman)) {
            return $this->errorResponse(2601);
        }
        return $this->successResponse($hangman, 2600);
    }

    /**
     * @OA\Get(
     *     path="/hangman/{id}",
     *     tags={"Hangman"},
     *     summary="Get hangman game by ID",
     *     description="Retrieves a hangman game by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hangman game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hangman game details",
     *         @OA\JsonContent(ref="#/components/schemas/Hangman")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hangman game not found"
     *     ),
     * )
     */
    public function getHangmanById($id) {
        $hangman = $this->getHangmanByIdUseCase->execute($id);
        if (empty($hangman)) {
            return $this->errorResponse(2604);
        }
        return $this->successResponse($hangman, 2603);
    }

    /**
     * @OA\Post(
     *     path="/hangman",
     *     tags={"Hangman"},
     *     summary="Create a new hangman game",
     *     description="Creates a new hangman game.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HangmanDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Hangman game created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Hangman")
     *     ),
     * )
     */
    public function createHangman(StoreHangmanRequest $request) {
        $validatedData = $request->validated();
        $hangmanDto = new HangmanDTO($validatedData);
        $hangman = $this->createHangmanUseCase->execute($hangmanDto);
        return $this->successResponse($hangman, 2606);
    }

    /**
     * @OA\Put(
     *     path="/hangman/{id}",
     *     tags={"Hangman"},
     *     summary="Update an existing hangman game",
     *     description="Updates an existing hangman game.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hangman game",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HangmanDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hangman game updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Hangman")
     *     ),
     * )
     */
    public function updateHangman(StoreHangmanRequest $request, $id) {
        $validatedData = $request->validated();
        $hangmanDto = new HangmanDTO($validatedData);
        $hangman = $this->updateHangmanUseCase->execute($id, $hangmanDto);
        return $this->successResponse($hangman, 2609);
    }
}