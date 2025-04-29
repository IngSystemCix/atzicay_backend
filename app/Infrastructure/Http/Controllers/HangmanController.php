<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\HangmanDTO;
use App\Application\UseCase\Hangman\CreateHangmanUseCase;
use App\Application\UseCase\Hangman\GetAllHangmanUseCase;
use App\Application\UseCase\Hangman\GetHangmanByIdUseCase;
use App\Application\UseCase\Hangman\DeleteHangmanUseCase;
use App\Application\UseCase\Hangman\UpdateHangmanUseCase;
use App\Infrastructure\Http\Requests\StoreHangmanRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Hangman",
 *     description="Operations related to Hangman"
 * )
 */
class HangmanController extends Controller
{
    private CreateHangmanUseCase $createHangmanUseCase;
    private GetHangmanByIdUseCase $getHangmanByIdUseCase;
    private GetAllHangmanUseCase $getAllHangmanUseCase;
    private UpdateHangmanUseCase $updateHangmanUseCase;
    private DeleteHangmanUseCase $deleteHangmanUseCase;
    public function __construct(
        CreateHangmanUseCase $createHangmanUseCase,
        GetHangmanByIdUseCase $getHangmanByIdUseCase,
        GetAllHangmanUseCase $getAllHangmanUseCase,
        UpdateHangmanUseCase $updateHangmanUseCase,
        DeleteHangmanUseCase $deleteHangmanUseCase
    ) {
        $this->createHangmanUseCase = $createHangmanUseCase;
        $this->getHangmanByIdUseCase = $getHangmanByIdUseCase;
        $this->getAllHangmanUseCase = $getAllHangmanUseCase;
        $this->updateHangmanUseCase = $updateHangmanUseCase;
        $this->deleteHangmanUseCase = $deleteHangmanUseCase;
    }
    
     /**
     * @OA\Post(
     *     path="/hangman",
     *     tags={"Hangman"},
     *     summary="Create a new Hangman",
     *     description="Creates a new Hangman.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *          required={"GameInstanceId", "Word", "Clue", "Presentation"},
     *          @OA\Property(property="GameInstanceId", type="integer", example=1),
     *          @OA\Property(property="Word", type="string", example="Peru"),
     *          @OA\Property(property="Clue", type="String", example="South American country"),
     *          @OA\Property(property="Presentation", type="string", example="A"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Correctly passed the hangman's game",
     *         @OA\JsonContent(ref="#/components/schemas/Hangman")
     *     ),
     *    @OA\Response(
     *       response=400,
     *      description="Invalid input"
     *    ),
     * )
     */

     public function createHangman(StoreHangmanRequest $request)
     {
        $data = $request->all();
        $dto = new HangmanDTO(
            gameInstanceId: $data['GameInstanceId'],
            word: $data['Word'],
            clue: $data['Clue'],
            presentation: $data['Presentation']
        );
        try {
            $hangman = $this->createHangmanUseCase->execute($dto);
            return response()->json($hangman, 201);
        }catch (\Exception $e) {
            return response()->json(['message' => 'Invalid input'],400);
        }
     }

      /**
     * @OA\Get(
     *     path="/hangman",
     *     tags={"Hangman"},
     *     summary="Get all hangmans",
     *     description="Retrieves all hangmans.",
     *     @OA\Response(
     *         response=200,
     *         description="List of hangmans",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Hangman"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No hangmans found"
     *     ),
     * )
     */
     public function getAllHangman(){
        $hangman = $this->getAllHangman->execute();
        if(!$hangman){
            return response()->json(['message'=> 'No hangmans found'],404);
        }
        return response()->json($hangman,200);
     }

     /**
     * @OA\Get(
     *     path="/hangman/{id}",
     *     tags={"Hangman"},
     *     summary="Get hangman by ID",
     *     description="Retrieves a hangman by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hangman to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Hangman found",
     *         @OA\JsonContent(ref="#/components/schemas/Hangman")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Hangman not found"
     *     ),
     * )
     */
     public function getHangmanById(int $id)
     {
        $hangman = $this->getHangmanByIdUseCase->execute($id);
        if(!$hangman) {
            return response()->json(['message'=> 'Hangman not found'],404);
        }
        return response()->json($hangman,200);
    } 

    /**
     * @OA\Put(
     *     path="/hangman/{id}",
     *     tags={"hangman"},
     *     summary="Update a hangman",
     *     description="Updates an existing hangman.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hangman to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/HangmanDTO")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Hangman updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Hangman")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Hangman not found"
     *      ),
     * )
     */
    public function updateHangman(StoreHangmanRequest $request, int $id){
        $data = $request->all();
        $dto = new HangmanDTO(
            $data['GameInstanceId'],
            $data['Word'],
            $data['Clue'],
            $data['Presentation'],
        );
        try {
            $hangman = $this->updateHangmanUseCase->execute($id, $data);
            return response()->json($hangman, 200);
        }catch (\Exception $e) {
            return response()->json(['message'=> 'Invalid input'], 400);
        }
        
    }

    /**
     * @OA\Delete(
     *     path="/hangman/{id}",
     *     tags={"hangman"},
     *     summary="Update a hangman",
     *     description="Delete an existing hangman.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the hangman to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Hangman deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Hangman")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Hangman not found"
     *      ),
     * )
     */
    public function deleteHangman(int $id){
        try {
            $this->getHangmanByIdUseCase->execute($id);
            $this->deleteHangmanUseCase->execute($id);
            return response()->json(['message'=> 'Hangman deleted successfully'],200);

        }catch (\Exception $e) {
            return response()->json(['message'=> 'Invalid input'], 400);
        }
    }
}
