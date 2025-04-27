<?php

namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\HangmanDTO;
use App\Application\UseCase\Hangman\CreateHangmanUseCase;
use Illuminate\Routing\Controller;

class HangmanController extends Controller
{
    private CreateHangmanUseCase $createHangmanUseCase;
    public function __construct(CreateHangmanUseCase $createHangmanUseCase)
    {
        $this->createHangmanUseCase = $createHangmanUseCase;
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

     public function CreateHangman(): mixed
     {
        $data = request()->all();

        $dto = new HangmanDTO(
            gameInstanceId: $data['GameInstanceId'],
            word: $data['Word'],
            clue: $data['Clue'],
            presentation: $data['Presentation']
        );

        $hangman = $this->createHangmanUseCase->execute($dto);

        return response()->json($hangman, 201);
     }
}
