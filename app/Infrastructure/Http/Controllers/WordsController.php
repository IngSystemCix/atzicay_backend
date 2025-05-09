<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\WordsDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\Words\CreateWordUseCase;
use App\Application\UseCase\Words\GetWordByIdUseCase;
use App\Application\UseCase\Words\UpdateWordUseCase;
use App\Infrastructure\Http\Requests\StoreWordsRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Words",
 *     description="Words operations"
 * )
 */
class WordsController extends Controller {
    use ApiResponse;
    private CreateWordUseCase $createWordUseCase;
    private GetWordByIdUseCase $getWordByIdUseCase;
    private UpdateWordUseCase $updateWordUseCase;

    public function __construct(
        CreateWordUseCase $createWordUseCase,
        GetWordByIdUseCase $getWordByIdUseCase,
        UpdateWordUseCase $updateWordUseCase
    ) {
        $this->createWordUseCase = $createWordUseCase;
        $this->getWordByIdUseCase = $getWordByIdUseCase;
        $this->updateWordUseCase = $updateWordUseCase;
    }

    /**
     * @OA\Get(
     *     path="/words/{id}",
     *     tags={"Words"},
     *     summary="Get Word by ID",
     *     description="Retrieves a Word by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the Word to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Word found",
     *         @OA\JsonContent(ref="#/components/schemas/Words")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Word not found"
     *     ),
     * )
     */
    public function getWordById($id) {
        $word = $this->getWordByIdUseCase->execute($id);
        if (!$word) {
            return $this->errorResponse(3101);
        }
        return $this->successResponse($word, 3100);
    }

    /**
     * @OA\Post(
     *     path="/words",
     *     tags={"Words"},
     *     summary="Create a new Word",
     *     description="Creates a new Word.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WordsDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Word created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Words")
     *     ),
     * )
     */
    public function createWord(StoreWordsRequest $request) {
        $validatedData = $request->validated();
        $dto = new WordsDTO($validatedData);
        $word = $this->createWordUseCase->execute($dto);
        return $this->successResponse($word, 3103);
    }

    /**
     * @OA\Put(
     *     path="/words/{id}",
     *     tags={"Words"},
     *     summary="Update a Word",
     *     description="Updates an existing Word.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the Word to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/WordsDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Word updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Words")
     *     ),
     * )
     */
    public function updateWord($id, StoreWordsRequest $request) {
        $validatedData = $request->validated();
        $dto = new WordsDTO($validatedData);
        $word = $this->updateWordUseCase->execute($id, $dto);
        return $this->successResponse($word, 3106);
    }
}