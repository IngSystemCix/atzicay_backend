<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\SolveTheWordDTO;
use App\Application\UseCase\SolveTheWord\CreateSolveTheWordUseCase;
use App\Application\UseCase\SolveTheWord\DeleteSolveTheWordUsecase;
use App\Application\UseCase\SolveTheWord\GetAllSolveTheWordUseCase;
use App\Application\UseCase\SolveTheWord\GetSolveTheWordByIdUseCase;
use App\Application\UseCase\SolveTheWord\UpdateSolveTheWordUseCase;
use App\Domain\Entities\SolveTheWord;
use App\Infrastructure\Http\Requests\StoreSolveTheWordRequest;

/**
 * @OA\Tag(
 *     name="SolveTheWord",
 *     description="Operations related to SolveTheWord"
 * )
 */
class SolveTheWordController extends Controller
{
    private CreateSolveTheWordUseCase $createSolveTheWordUseCase;
    private GetSolveTheWordByIdUseCase $getSolveTheWordByIdUseCase;
    private GetAllSolveTheWordUseCase $getAllSolveTheWordUseCase;
    private UpdateSolveTheWordUseCase $updateSolveTheWordUseCase;
    private DeleteSolveTheWordUsecase $deleteSolveTheWordUsecase;
    public function __construct(
        CreateSolveTheWordUseCase $createSolveTheWordUseCase,
        GetSolveTheWordByIdUseCase $getSolveTheWordByIdUseCase,
        GetAllSolveTheWordUseCase $getAllSolveTheWordUseCase,
        UpdateSolveTheWordUseCase $updateSolveTheWordUseCase,
        DeleteSolveTheWordUsecase $deleteSolveTheWordUsecase
    ) {
        $this->createSolveTheWordUseCase = $createSolveTheWordUseCase;
        $this->getSolveTheWordByIdUseCase = $getSolveTheWordByIdUseCase;
        $this->getAllSolveTheWordUseCase = $getAllSolveTheWordUseCase;
        $this->updateSolveTheWordUseCase = $updateSolveTheWordUseCase;
        $this->deleteSolveTheWordUsecase = $deleteSolveTheWordUsecase;
    }

       /**
     * @OA\Post(
     *     path="/solveTheWord",
     *     tags={"SolveTheWord"},
     *     summary="Create a new SolveTheWord",
     *     description="Creates a new solve the word.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *          required={"GameInstanceId", "Rows", "Cols"},
     *          @OA\Property(property="GameInstanceId", type="integer", example=1),
     *          @OA\Property(property="Rows", type="integer", example=6
     *          @OA\Property(property="Cols", type="integer", example=6
     *         ),
     *         ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Correctly passed the Solve the word game",
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWord")
     *     ),
     *    @OA\Response(
     *       response=400,
     *      description="Invalid input"
     *    ),
     * )
     */
    public function createSolveTheWord (StoreSolveTheWordRequest $request)
    {
        $data = $request->All();
        $dto = new SolveTheWordDTO(
            $data["GameInstanceId"],
            $data["Rows"],
            $data["Cols"],
        );
        try {
            $solveTheWord = $this->createSolveTheWordUseCase->execute($dto);
            return response()->json($solveTheWord,201);
        }catch (Exception $e) {
            return response()->json(['message'=>'Invalid input',400]);
        }
    }

        /**
     * @OA\Get(
     *     path="/solveTheWord",
     *     tags={"SolveTheWord"},
     *     summary="Get all SolveTheWord",
     *     description="Retrieves all Solve the word.",
     *     @OA\Response(
     *         response=200,
     *         description="List of solveTheWord",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/SolveTheWord"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No Solve the word found"
     *     ),
     * )
     */
    public function getAllSolveTheWord(){
        $solveTheWord = $this->getAllSolveTheWord->execute();
        if(!$solveTheWord){
            return response()->json(['message'=> 'No Solve the word found',400]);
        }
        return response()->json($solveTheWord,200);
    }

       /**
     * @OA\Get(
     *     path="/solveTheWord/{id}",
     *     tags={"SolveTheWord"},
     *     summary="Get solveTheWord by ID",
     *     description="Retrieves a solve the word by its ID.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the solve the word to retrieve",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Solve the word not found",
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWord")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Solve the word not found"
     *     ),
     * )
     */
    public function getSolveTheWorById(int $id){
        $solveTheWord = $this->getSolveTheWordByIdUseCase->execute($id);
        if(!$solveTheWord){
            return response()->json(['message'=> 'Solve the word not found',400]);
        }
        return response()->json($solveTheWord,200);
    }

        /**
     * @OA\Put(
     *     path="/solveTheWord/{id}",
     *     tags={"SolveThWord"},
     *     summary="Update a solve the word",
     *     description="Updates an existing solve the word.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the solve the word to update",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWordDTO")
     *      ),
     *      @OA\Response(
     *         response=200,
     *         description="Solve the word updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWord")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Solve the word not found"
     *      ),
     * )
     */
    public function updateSolveTheWord(StoreSolveTheWordRequest $request, int $id){
        $data = $request->All();
        $dto = new SolveTheWordDTO(
            $data['GameInstaceId'],
            $data['Rows'],
            $data['Cols'],
        );
        try {
            $solveTheWord = $this->updateSolveTheWordUseCase->execute($id, $data);
            return response()->json($solveTheWord,200);
        }catch (Exception $e){
            return response()->json(['message'=>'Invalid input',400]);
        }
    }

        /**
     * @OA\Delete(
     *     path="/solveTheWord/{id}",
     *     tags={"SolveTheWord"},
     *     summary="Update a solve the word",
     *     description="Updates an existing solve the word.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the solve the word to update",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *         response=200,
     *         description="Puzzle updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/SolveTheWord")
     *      ),
     *      @OA\Response(
     *         response=404,
     *         description="Solve the word not found"
     *      ),
     * )
     */
    public function deleteSolveTheWord(int $id){
        try {
            $this->getAllSolveTheWordUseCase->execute($id);
            $this->deleteSolveTheWordUsecase->execute($id);
            return response()->json(['message'=> 'Solve the Word deleted successfully',200]);
        }catch (Exception $e){
            return response()->json(['message'=> 'Invalid input',400]);
        }
    }
}