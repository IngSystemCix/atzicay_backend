<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\MemoryGameDTO;
use App\Application\UseCase\MemoryGame\CreateMemoryGameUseCase;
use App\Application\UseCase\MemoryGame\GetAllMemoryGameUseCase;
use App\Application\UseCase\MemoryGame\GetMemoryGameByIdUseCase;
use App\Application\UseCase\MemoryGame\DeleteMemoryGameUseCase;
use App\Application\UseCase\MemoryGame\UpdateMemoryGameUseCase;
use App\Infrastructure\Http\Requests\StoreMemoryGameRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="MemoryGame",
 *     description="Operations related to MemoryGame"
 * )
 */

 class MemoryGameController extends Controller
 {
    private CreateMemoryGameUseCase $createMemoryGameUseCase;
    private GetAllMemoryGameUseCase $getAllMemoryGameUseCase;
    private GetMemoryGameByIdUseCase $getAllMemoryGameByIdUseCase;
    private UpdateMemoryGameUseCase $updateMemoryGameUseCase;
    private DeleteMemoryGameUseCase $deleteMemoryGameUseCase;

    public function __construct(
        CreateMemoryGameUseCase $createMemoryGameUseCase,
        GetAllMemoryGameUseCase $getAllMemoryGameUseCase,
        GetMemoryGameByIdUseCase $getAllMemoryGameByIdUseCase,
        UpdateMemoryGameUseCase $updateMemoryGameUseCase,
        DeleteMemoryGameUseCase $deleteMemoryGameUseCase,
     ) {
        $this->createMemoryGameUseCase = $createMemoryGameUseCase;
        $this->getAllMemoryGameUseCase = $getAllMemoryGameUseCase;
        $this->getMemoryGameByIdUseCase = $getAllMemoryGameByIdUseCase;
        $this->updateMemoryGameUseCase = $updateMemoryGameUseCase;
        $this->deleteMemoryGameUseCase = $deleteMemoryGameUseCase;
     }

     /**
     * @OA\Post(
     *     path="/memoryGame",
     *     tags={"MemoryGame"},
     *     summary="Create a new MemoryGame",
     *     description="Creates a new MemoryGame.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *          required={"GameInstanceId", "Mode", "PathImg1", "PathImg2","DescriptionImg"},
     *          @OA\Property(property="GameInstanceId", type="integer", example=1),
     *          @OA\Property(property="Mode", type="string", example="ID"),
     *          @OA\Property(property="PathImg1", type="String", example="MancoCapac.png"),
     *          @OA\Property(property="PathImg2", type="string", example="MamaOcllo.png"
     *         ),
     *          @OA\Property(property="DescriptionImg", type="string", example="First people to arrive at Machu Picchu"),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Correctly passed the memoryGames",
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGame")
     *     ),
     *    @OA\Response(
     *       response=400,
     *      description="Invalid input"
     *    ),
     * )
     */
     public function createMemoryGame(StoreMemoryGameRequest $request)
     {
       $data = $request->all();
       $dto = new MemoryGameDTO(
            gameInstanceId: $data['GameInstanceId'],
            mode: $data['Mode'],
            pathImg1: $data['PathImg1'],
            pathImg2: $data['PathImg2'],
            descriptionImg: $data['DescriptionImg'],
       );
       try {
           $memoryGame = $this->createMemoryGameUseCase->execute($dto);
           return response()->json($memoryGame,201);
       }catch (Exception $e) {
         return response()->json(['messaje'=>'Invalid input'],400);
       }
     }


      /**
     * @OA\Get(
     *     path="/memoryGame",
     *     tags={"MemoryGame"},
     *     summary="Get all memoryGames",
     *     description="Retrieves all memoryGames.",
     *     @OA\Response(
     *         response=200,
     *         description="List of memoryGames",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/MemoryGame"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No memoryGames found"
     *     ),
     * )
     */
     public function getAllMemoryGame(){
        $memoryGame = $this->getAllMemoryGameUseCase->execute();
        if(!memoryGame){
          return response()->json(['message'=> 'No MemoryGames found'],404);
        }
        return response()->json($memoryGame,200);
     }
      /**
     * @OA\Get(
     *     path="/memoryGame/{id}",
     *     tags={"MemoryGame"},
     *     summary="Get memoryGame by ID",
     *     description="Retrieves a memoryGame by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the memoryGame to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="memoryGame found",
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGame")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="memoryGame not found"
     *     ),
     * )
     */
     public function getAllMemoryGameById(Sint $id)
     {
      $memoryGame = $this->getAllMemoryGameByIdUseCase->execute($id);
      if(!memoryGame){
        return response()->json(['message'=> 'MemoryGame not found'],404);
      }
      return response()->json($memoryGame,200);
     }

     /**
     * @OA\Put(
     *     path="/memoryGame/{id}",
     *     tags={"MemoryGame"},
     *     summary="Update an memoryGame",
     *     description="Updates an existing memoryGame.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the memoryGame to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGameDTO")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="MemoryGame updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGame")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="MemoryGame not found"
     *      ),
     * )
     */
    public function updateMemoryGame(StoreMemoryGameRequest $request, int $id){
      $data = $request->all();
      $dto = new MemoryGameDTO(
          $data['GameInstanceId'],
          $data['Mode'],
          $data['PathImg1'],
          $data['PathImg2'],
          $data['DescriptionImg'],
      );
      try {
          $memoryGame = $this->updateMemoryGameUseCase->execute($id, $data);
          return response()->json($memoryGame, 200);
      }catch (\Exception $e) {
          return response()->json(['message'=> 'Invalid input'], 400);
      }
    }

     /**
     * @OA\Put(
     *     path="/memoryGame/{id}",
     *     tags={"MemoryGame"},
     *     summary="Update a memoryGame",
     *     description="Delete an existing memoryGame.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the memoryGame to delete",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/MemoryGameDTO")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="memoryGame deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/memoryGame")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="memoryGame not found"
     *      ),
     * )
     */
    public function deleteMemorGame(int $id){
      try {
          $this->getAllMemoryGameByIdUseCase->execute($id);
          $this->deleteMemoryGameUseCase->execute($id);
          return response()->json(['message'=> 'MemoryGame deleted successfully'],200);

      }catch (\Exception $e) {
          return response()->json(['message'=> 'Invalid input'], 400);
      }
  }
 }

 
