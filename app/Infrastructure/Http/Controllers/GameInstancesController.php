<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\GameInstancesDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\GameInstances\CountGameTypesByProfessorUseCase;
use App\Application\UseCase\GameInstances\CreateGameInstanceUseCase;
use App\Application\UseCase\GameInstances\DeleteGameInstanceUseCase;
use App\Application\UseCase\GameInstances\GetAllGameInstancesUseCase;
use App\Application\UseCase\GameInstances\GetAllGameUseCase;
use App\Application\UseCase\GameInstances\GetGameInstanceByIdUseCase;
use App\Application\UseCase\GameInstances\SearchUseCase;
use App\Application\UseCase\GameInstances\UpdateGameInstanceUseCase;
use App\Domain\Services\GameService;
use App\Infrastructure\Http\Requests\StoreGameInstancesRequest;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="GameInstances",
 *     description="Operations related to game instances"
 * ),
 */
class GameInstancesController extends Controller
{
    use ApiResponse;
    private GameService $gameService;
    private CreateGameInstanceUseCase $createGameInstanceUseCase;
    private GetAllGameInstancesUseCase $getAllGameInstancesUseCase;
    private GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase;
    private UpdateGameInstanceUseCase $updateGameInstanceUseCase;
    private DeleteGameInstanceUseCase $deleteGameInstanceUseCase;
    private GetAllGameUseCase $getAllGameUseCase;
    private SearchUseCase $searchUseCase;
    private CountGameTypesByProfessorUseCase $countGameTypesByProfessorUseCase;

    public function __construct(
        GameService $gameService,
        CreateGameInstanceUseCase $createGameInstanceUseCase,
        GetAllGameInstancesUseCase $getAllGameInstancesUseCase,
        GetAllGameUseCase $getAllGameUseCase,
        GetGameInstanceByIdUseCase $getGameInstanceByIdUseCase,
        UpdateGameInstanceUseCase $updateGameInstanceUseCase,
        DeleteGameInstanceUseCase $deleteGameInstanceUseCase,
        SearchUseCase $searchUseCase,
        CountGameTypesByProfessorUseCase $countGameTypesByProfessorUseCase
    ) {
        $this->gameService = $gameService;
        $this->createGameInstanceUseCase = $createGameInstanceUseCase;
        $this->getAllGameInstancesUseCase = $getAllGameInstancesUseCase;
        $this->getAllGameUseCase = $getAllGameUseCase;
        $this->getGameInstanceByIdUseCase = $getGameInstanceByIdUseCase;
        $this->updateGameInstanceUseCase = $updateGameInstanceUseCase;
        $this->deleteGameInstanceUseCase = $deleteGameInstanceUseCase;
        $this->searchUseCase = $searchUseCase;
        $this->countGameTypesByProfessorUseCase = $countGameTypesByProfessorUseCase;
    }

    /**
     * @OA\Get(
     *     path="/game-instances/personal/{id}",
     *     tags={"GameInstances"},
     *     summary="Get all game instances by professor ID with optional game type filter",
     *     description="Retrieves all game instances for a specific professor, optionally filtered by game type.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID of the professor",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="gameType",
     *         in="query",
     *         required=false,
     *         description="Filter by game type: all, hangman, memory, puzzle, solve_the_word",
     *         @OA\Schema(type="string", enum={"all", "hangman", "memory", "puzzle", "solve_the_word"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of game instances",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/GameInstances"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No game instances found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function getAllGameInstances($id)
    {
        $gameType = request()->query('gameType', 'all'); // obtener de query param o 'all' por defecto

        $gameInstances = $this->getAllGameInstancesUseCase->execute($id, $gameType);

        return $this->successResponse($gameInstances, 2201);
    }

    /**
     * @OA\Get(
     *     path="/programming-games/filter",
     *     tags={"ProgrammingGame"},
     *     summary="Filtrar ProgrammingGames por fechas",
     *     description="Filtra las programaciones por fecha de inicio, fin o un rango de fechas.",
     *     @OA\Parameter(
     *         name="start",
     *         in="query",
     *         required=false,
     *         description="Fecha de inicio (Y-m-d)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Parameter(
     *         name="end",
     *         in="query",
     *         required=false,
     *         description="Fecha de fin (Y-m-d)",
     *         @OA\Schema(type="string", format="date")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de ProgrammingGames filtrados",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ProgrammingGame"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron resultados"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function filterProgrammingGames(Request $request)
    {
        return $this->gameService->filterProgrammingGames($request);
    }

    /**
     * @OA\Get(
     *     path="/game-instances/personal/count/{id}",
     *     tags={"GameInstances"},
     *     summary="Get game counts by type for a professor",
     *     description="Returns the total number of each game type created by a specific professor.",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Professor ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game type counts",
     *         @OA\JsonContent(
     *             @OA\Property(property="hangman", type="integer"),
     *             @OA\Property(property="memory", type="integer"),
     *             @OA\Property(property="puzzle", type="integer"),
     *             @OA\Property(property="solve_the_word", type="integer")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function countGameTypesByProfessor($id)
    {
        $counts = $this->countGameTypesByProfessorUseCase->execute($id);
        return $this->successResponse($counts, 2221);
    }

    /**
     * @OA\Get(
     *     path="/game-instances/search",
     *     summary="Buscar game instances",
     *     operationId="searchGameInstances",
     *     tags={"GameInstances"},
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Nombre del game instance",
     *         required=false,
     *         @OA\Schema(type="string", maxLength=40)
     *     ),
     *     @OA\Parameter(
     *         name="author",
     *         in="query",
     *         description="ID del autor (professor_id)",
     *         required=false,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Parameter(
     *         name="type",
     *         in="query",
     *         description="Tipo de juego (MEMORY_GAME, HANGMAN, PUZZLE, SOLVE_THE_WORD)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"MEMORY_GAME", "HANGMAN", "PUZZLE", "SOLVE_THE_WORD"})
     *     ),
     *     @OA\Parameter(
     *         name="difficulty",
     *         in="query",
     *         description="Dificultad (E=Easy, M=Medium, D=Difficult)",
     *         required=false,
     *         @OA\Schema(type="string", enum={"E", "M", "D"})
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de game instances filtradas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/GameInstances")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontraron resultados",
     *         @OA\JsonContent(
     *             @OA\Property(property="code", type="integer", example=2212),
     *             @OA\Property(property="message", type="string", example="No se encontraron game instances")
     *         )
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function searchGameInstances(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:40',
            'author' => 'nullable|integer|exists:users,id',
            'type' => 'nullable|string|in:MEMORY_GAME,HANGMAN,PUZZLE,SOLVE_THE_WORD',
            'difficulty' => 'nullable|in:E,M,D',
        ]);

        $gameInstances = $this->searchUseCase->execute($request);

        if (empty($gameInstances)) {
            return $this->errorResponse(2212);
        }

        return $this->successResponse($gameInstances, 2213);
    }


    /**
     * @OA\Get(
     *     path="/game-instances/all/{limit}",
     *     tags={"Games"},
     *     summary="Get all games",
     *     description="Retrieves all games.",
     *     @OA\Response(
     *         response=200,
     *         description="List of games",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 @OA\Property(property="id", type="integer"),
     *                 @OA\Property(property="title", type="string"),
     *                 @OA\Property(property="level", type="string"),
     *                 @OA\Property(property="description", type="string"),
     *                 @OA\Property(property="rating", type="integer"),
     *                 @OA\Property(property="author", type="string")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No games found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function getAllGame($limit = 6)
    {
        $games = $this->getAllGameUseCase->execute($limit);
        if (empty($games)) {
            return $this->errorResponse(2210);
        }
        return $this->successResponse($games, 2211);
    }

    /**
     * @OA\Get(
     *     path="/game-instances/{id}",
     *     tags={"GameInstances"},
     *     summary="Get game instance by ID",
     *     description="Retrieves a game instance by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance details",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game instance not found"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function getGameInstanceById($id)
    {
        $gameInstance = $this->getGameInstanceByIdUseCase->execute($id);
        if (empty($gameInstance)) {
            return $this->errorResponse(2202);
        }
        return $this->successResponse($gameInstance, 2203);
    }

    /**
     * @OA\Post(
     *     path="/game-instances",
     *     tags={"GameInstances"},
     *     summary="Create a new game instance",
     *     description="Creates a new game instance.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameInstancesDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Game instance created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function createGameInstance(StoreGameInstancesRequest $request)
    {
        $validatedData = $request->validated();
        $gameInstanceDto = new GameInstancesDTO($validatedData);
        $gameInstance = $this->createGameInstanceUseCase->execute($gameInstanceDto);
        return $this->successResponse($gameInstance, 2205);
    }

    /**
     * @OA\Put(
     *     path="/game-instances/{id}",
     *     tags={"GameInstances"},
     *     summary="Update a game instance",
     *     description="Updates an existing game instance.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/GameInstancesDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function updateGameInstance($id, StoreGameInstancesRequest $request)
    {
        $validatedData = $request->validated();
        $gameInstanceDto = new GameInstancesDTO($validatedData);
        $gameInstance = $this->updateGameInstanceUseCase->execute($id, $gameInstanceDto);
        return $this->successResponse($gameInstance, 2207);
    }

    /**
     * @OA\Delete(
     *     path="/game-instances/{id}",
     *     tags={"GameInstances"},
     *     summary="Delete a game instance",
     *     description="Deletes a game instance by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance deleted successfully",
     *         @OA\JsonContent(ref="#/components/schemas/GameInstances")
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function deleteGameInstance($id)
    {
        $gameInstance = $this->deleteGameInstanceUseCase->execute($id);
        if (empty($gameInstance)) {
            return $this->errorResponse(2208);
        }
        return $this->successResponse($gameInstance, 2209);
    }

    /**
     * @OA\Post(
     *     path="/game-instances/game",
     *     operationId="createGame",
     *     tags={"Games"},
     *     summary="Crear una nueva instancia de juego",
     *     description="Crea un nuevo juego con sus configuraciones, tipo específico (programming, hangman, puzzle, etc.), evaluación inicial y settings.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"Name", "Description", "ProfessorId", "Activated", "Difficulty", "Visibility", "game_type"},
     *             @OA\Property(property="Name", type="string", example="Juego de Prueba"),
     *             @OA\Property(property="Description", type="string", example="Juego para evaluar lógica básica."),
     *             @OA\Property(property="ProfessorId", type="integer", example=1),
     *             @OA\Property(property="Activated", type="boolean", example=true),
     *             @OA\Property(property="Difficulty", type="string", example="Fácil"),
     *             @OA\Property(property="Visibility", type="string", example="Público"),
     *             @OA\Property(
     *                 property="settings",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="ConfigKey", type="string", example="TiempoLimite"),
     *                     @OA\Property(property="ConfigValue", type="string", example="30")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="assessment",
     *                 type="object",
     *                 @OA\Property(property="value", type="number", format="float", example=8.5),
     *                 @OA\Property(property="comments", type="string", example="Buen desempeño")
     *             ),
     *             @OA\Property(
     *                 property="programming_game",
     *                 type="object",
     *                 @OA\Property(property="name", type="string", example="Algoritmos Básicos"),
     *                 @OA\Property(property="start_time", type="string", format="date-time", example="2025-06-01T09:00:00Z"),
     *                 @OA\Property(property="end_time", type="string", format="date-time", example="2025-06-01T10:00:00Z"),
     *                 @OA\Property(property="attempts", type="integer", example=3),
     *                 @OA\Property(property="maximum_time", type="integer", example=60)
     *             ),
     *             @OA\Property(property="game_type", type="string", example="hangman"),
     *             @OA\Property(
     *                 property="hangman",
     *                 type="object",
     *                 @OA\Property(property="word", type="string", example="programacion"),
     *                 @OA\Property(property="max_attempts", type="integer", example=5)
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Instancia de juego creada exitosamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Datos inválidos o faltantes"
     *     ),
     *     security={{"bearerAuth": {}}}
     * )
     */
    public function createGame(Request $request)
    {
        $gameInstance = $this->gameService->createGame($request);
        return $this->successResponse($gameInstance, 2214); // o el retorno según tu `ApiResponse`
    }

    /**
     * @OA\Get(
     *     path="/game-instances/configuration/{id}",
     *     summary="Obtener configuración de una instancia de juego por ID",
     *     tags={"Game Instances"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la instancia del juego",
     *         required=true,
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Datos de la instancia de juego",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="id", type="integer", example=1),
     *             @OA\Property(property="title", type="string", example="Ahorcado Nivel 1"),
     *             @OA\Property(property="description", type="string", example="Juego básico para niños"),
     *             @OA\Property(property="difficulty", type="string", example="Fácil"),
     *             @OA\Property(property="visibility", type="boolean", example=true),
     *             @OA\Property(property="activated", type="boolean", example=true),
     *             @OA\Property(property="rating", type="number", format="float", example=4.5),
     *             @OA\Property(
     *                 property="assessment",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="value", type="number", example=4),
     *                     @OA\Property(property="comments", type="string", example="Muy bueno")
     *                 )
     *             ),
     *             @OA\Property(property="author", type="string", example="Juan Pérez"),
     *             @OA\Property(property="type", type="string", example="Hangman"),
     *             @OA\Property(
     *                 property="settings",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="key", type="string", example="time_limit"),
     *                     @OA\Property(property="value", type="string", example="60")
     *                 )
     *             ),
     *             @OA\Property(
     *                 property="game_data",
     *                 type="object",
     *                 oneOf={
     *                     @OA\Schema(
     *                         @OA\Property(property="word", type="string", example="Sol"),
     *                         @OA\Property(property="clue", type="string", example="Brilla en el cielo"),
     *                         @OA\Property(property="presentation", type="string", example="Imagen del sol")
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(property="pieces", type="integer", example=16),
     *                         @OA\Property(property="image_url", type="string", example="https://cdn.ejemplo.com/puzzle1.jpg")
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(property="mode", type="string", example="parejas"),
     *                         @OA\Property(property="path_img1", type="string", example="img1.png"),
     *                         @OA\Property(property="path_img2", type="string", example="img2.png"),
     *                         @OA\Property(property="description_img", type="string", example="Animales")
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(property="rows", type="integer", example=5),
     *                         @OA\Property(property="columns", type="integer", example=5),
     *                         @OA\Property(
     *                             property="words",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="word", type="string", example="PERRO"),
     *                                 @OA\Property(property="orientation", type="string", example="horizontal")
     *                             )
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Instancia no encontrada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Game not found")
     *         )
     *     )
     * )
     */
    public function getConfigurations(int $id)
    {
        $gameInstances = $this->gameService->getGameById($id);

        if (!$gameInstances) {
            return $this->errorResponse(2216);
        }

        return $this->successResponse($gameInstances, 2217);
    }

    public function programmingGame(Request $request, $id)
    {
        $programming = $this->gameService->programmingGame($request, $id);
        return $this->successResponse($programming, 2218);
    }

    public function editGame(Request $request, $id)
    {
        $updateGame = $this->gameService->updateGame($request, $id);
        return $this->successResponse($updateGame, 2219);
    }

    public function progressGame(Request $request)
    {
        $saveProgress = $this->gameService->createGameSessionWithProgress($request);
        return $this->successResponse($saveProgress, 2220);
    }
}