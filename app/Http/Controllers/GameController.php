<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class GameController extends Controller
{
    protected GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    /**
     * @OA\Get(
     *     path="/game/filter",
     *     operationId="gameAllFilter",
     *     tags={"Games"},
     *     summary="Get filtered list of games",
     *     description="Returns a list of games filtered by search term, game type, with pagination.",
     *     @OA\Parameter(
     *         name="search",
     *         in="query",
     *         description="Search term for game name or author",
     *         required=false,
     *         @OA\Schema(type="string", example="Puzzle Game")
     *     ),
     *     @OA\Parameter(
     *         name="gameType",
     *         in="query",
     *         description="Type of game to filter",
     *         required=false,
     *         @OA\Schema(type="string", enum={"hangman", "memory", "puzzle", "solve_the_word", "all"}, example="puzzle")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of results to return",
     *         required=false,
     *         @OA\Schema(type="integer", example=6)
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Number of results to skip",
     *         required=false,
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Games retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="total", type="integer", example=12),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="name", type="string", example="Memory Challenge"),
     *                         @OA\Property(property="difficulty", type="string", example="easy"),
     *                         @OA\Property(property="author", type="string", example="John Doe"),
     *                         @OA\Property(property="type_game", type="string", example="memory"),
     *                         @OA\Property(property="rating", type="number", format="float", example=4.5),
     *                         @OA\Property(property="game_instance_id", type="integer", example=5),
     *                         @OA\Property(property="author_id", type="integer", example=2)
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Games retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving games.")
     *         )
     *     )
     * )
     */
    public function gameAllFilter(): JsonResponse
    {
        $search = request()->query('search', null);
        $gameType = request()->query('gameType', null);
        $limit = (int) request()->query('limit', 6);
        $offset = (int) request()->query('offset', 0);

        $games = $this->gameService->gameAllFilter($search, $gameType, $limit, $offset);

        return ApiResponse::success($games, 'Games retrieved successfully');
    }

    /**
     * @OA\Get(
     *     path="/game/amount-by-type/{userId}",
     *     operationId="amountByGameType",
     *     tags={"Games"},
     *     summary="Get the amount of games by type for a specific user",
     *     description="Returns the count of each game type created by the specified user (professor).",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of the user (professor)",
     *         required=true,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Amount of games by type retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="hangman_count", type="integer", example=3),
     *                 @OA\Property(property="memorygame_count", type="integer", example=2),
     *                 @OA\Property(property="puzzle_count", type="integer", example=5),
     *                 @OA\Property(property="solvetheword_count", type="integer", example=4)
     *             ),
     *             @OA\Property(property="message", type="string", example="Amount of games by type retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving game amounts")
     *         )
     *     )
     * )
     */
    public function amountByGameType(int $userId): JsonResponse
    {
        $amount = $this->gameService->amountByGameType($userId);
        return ApiResponse::success($amount, 'Amount of games by type retrieved successfully');
    }

    /**
     * @OA\Get(
     *     path="/my-games/{userId}",
     *     operationId="myGames",
     *     tags={"Games"},
     *     summary="Get all games created by a specific user (professor)",
     *     description="Returns a paginated list of all games created by the specified user (professor), optionally filtered by game type.",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of the user (professor)",
     *         required=true,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Parameter(
     *         name="gameType",
     *         in="query",
     *         description="Type of game to filter",
     *         required=false,
     *         @OA\Schema(type="string", enum={"hangman", "memory", "puzzle", "solve_the_word", "all"}, example="puzzle")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of results to return per page",
     *         required=false,
     *         @OA\Schema(type="integer", example=6)
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Number of results to skip (for pagination)",
     *         required=false,
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="My games retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="total", type="integer", example=12),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="name", type="string", example="Puzzle Master"),
     *                         @OA\Property(property="difficulty", type="string", example="medium"),
     *                         @OA\Property(property="visibility", type="string", example="public"),
     *                         @OA\Property(property="author", type="string", example="Jane Smith"),
     *                         @OA\Property(property="type_game", type="string", example="puzzle"),
     *                         @OA\Property(property="rating", type="number", format="float", example=4.7),
     *                         @OA\Property(property="game_instance_id", type="integer", example=7),
     *                         @OA\Property(property="author_id", type="integer", example=3)
     *                     )
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="My games retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving user's games")
     *         )
     *     )
     * )
     */
    public function myGames(int $userId): JsonResponse
    {
        $gameType = request()->query('gameType', null);
        $limit = (int) request()->query('limit', 6);
        $offset = (int) request()->query('offset', 0);
        $myGames = $this->gameService->myGames($userId, $gameType, $limit, $offset);
        return ApiResponse::success($myGames, 'My games retrieved successfully');
    }

    /**
     * @OA\Put(
     *     path="/my-game/update-status/{gameInstanceId}",
     *     operationId="updateStatusGameInstance",
     *     tags={"Games"},
     *     summary="Update the visibility status of a game instance",
     *     description="Updates the visibility (status) of a specific game instance.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         description="ID of the game instance to update",
     *         required=true,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="boolean", example=true, description="New status (visibility) of the game instance")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance status updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="string", nullable=true, example=null),
     *             @OA\Property(property="message", type="string", example="Game instance status updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game instance not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Game instance not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="status",
     *                     type="array",
     *                     @OA\Items(type="string", example="The status field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Failed to update game instance status",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Failed to update game instance status")
     *         )
     *     )
     * )
     */
    public function updateStatusGameInstance(int $gameInstanceId, Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'status' => 'required|boolean',
        ]);
        $status = $validatedData['status'];
        $result = $this->gameService->updateStatus($gameInstanceId, $status);
        if ($result) {
            return ApiResponse::success(null, 'Game instance status updated successfully');
        } else {
            return ApiResponse::error('Failed to update game instance status', 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/my-game/update/{gameInstanceId}",
     *     operationId="updateGameInstance",
     *     tags={"Games"},
     *     summary="Update a game instance based on its type",
     *     description="Updates a game instance for the specified type: hangman, memory, puzzle, or solve_the_word.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         description="ID of the game instance to update",
     *         required=true,
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"gameType", "data"},
     *             @OA\Property(property="gameType", type="string", enum={"hangman", "memory", "puzzle", "solve_the_word"}, example="puzzle"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 oneOf={
     *                     @OA\Schema(
     *                         @OA\Property(property="Word", type="string", example="APPLE"),
     *                         @OA\Property(property="Clue", type="string", example="A fruit"),
     *                         @OA\Property(property="Presentation", type="string", example="standard")
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(property="Mode", type="string", enum={"II", "ID"}, example="II"),
     *                         @OA\Property(property="PathImage1", type="string", format="binary"),
     *                         @OA\Property(property="PathImage2", type="string", format="binary"),
     *                         @OA\Property(property="Description", type="string", example="Match the animals")
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(property="PathImg", type="string", format="binary"),
     *                         @OA\Property(property="Clue", type="string", example="Solve the landscape puzzle"),
     *                         @OA\Property(property="Rows", type="integer", example=3),
     *                         @OA\Property(property="Cols", type="integer", example=3),
     *                         @OA\Property(property="AutomaticHelp", type="boolean", example=true)
     *                     ),
     *                     @OA\Schema(
     *                         @OA\Property(property="Rows", type="integer", example=5),
     *                         @OA\Property(property="Cols", type="integer", example=5),
     *                         @OA\Property(
     *                             property="Words",
     *                             type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="Id", type="integer", example=1),
     *                                 @OA\Property(property="Word", type="string", example="CAT"),
     *                                 @OA\Property(property="Orientation", type="string", example="HR")
     *                             )
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game instance updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Puzzle game updated successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game instance not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Game instance not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="gameType",
     *                     type="array",
     *                     @OA\Items(type="string", example="The gameType field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error updating game instance: Some error message")
     *         )
     *     )
     * )
     */
    public function updateGameInstance(int $gameInstanceId, Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'gameType' => 'required|string|in:hangman,memory,puzzle,solve_the_word',
            'data' => 'required|array'
        ]);
        $gameType = $validatedData['gameType'];
        $data = $validatedData['data'];
        try {
            $message = $this->gameService->updateByGameType($gameInstanceId, $gameType, $data);

            return response()->json([
                'success' => true,
                'message' => $message
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating game instance: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/my-game/create/{userId}",
     *     operationId="createGame",
     *     tags={"Games"},
     *     summary="Create a new game instance by type",
     *     description="Creates a game instance for the specified type: hangman, memory, puzzle, or solve_the_word, with mandatory settings.",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         description="ID of the professor (user) who creates the game",
     *         required=true,
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"gameType", "data"},
     *             @OA\Property(property="gameType", type="string", enum={"hangman", "memory", "puzzle", "solve_the_word"}, example="hangman"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 oneOf={
     *                     @OA\Schema(
     *                         required={"Words", "Settings"},
     *                         @OA\Property(property="Name", type="string", example="My Hangman Game"),
     *                         @OA\Property(property="Description", type="string", example="Hangman for kids"),
     *                         @OA\Property(property="Words", type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="Word", type="string", example="APPLE"),
     *                                 @OA\Property(property="Clue", type="string", example="A fruit"),
     *                                 @OA\Property(property="Presentation", type="string", example="standard")
     *                             )
     *                         ),
     *                         @OA\Property(property="Difficulty", type="string", example="Easy"),
     *                         @OA\Property(property="Activated", type="boolean", example=true),
     *                         @OA\Property(property="Visibility", type="string", example="Public"),
     *                         @OA\Property(property="Settings", type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="Key", type="string", example="time_limit"),
     *                                 @OA\Property(property="Value", type="string", example="60")
     *                             )
     *                         )
     *                     ),
     *                     @OA\Schema(
     *                         required={"Mode", "Settings"},
     *                         @OA\Property(property="Name", type="string", example="Memory Game"),
     *                         @OA\Property(property="Description", type="string", example="Find the pairs"),
     *                         @OA\Property(property="Mode", type="string", enum={"II", "ID"}, example="II"),
     *                         @OA\Property(property="PathImage1", type="string", format="binary"),
     *                         @OA\Property(property="PathImage2", type="string", format="binary"),
     *                         @OA\Property(property="Difficulty", type="string", example="Medium"),
     *                         @OA\Property(property="Activated", type="boolean", example=true),
     *                         @OA\Property(property="Visibility", type="string", example="Private"),
     *                         @OA\Property(property="Settings", type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="Key", type="string", example="max_pairs"),
     *                                 @OA\Property(property="Value", type="string", example="8")
     *                             )
     *                         )
     *                     ),
     *                     @OA\Schema(
     *                         required={"PathImg", "Rows", "Cols", "Settings"},
     *                         @OA\Property(property="Name", type="string", example="Puzzle Challenge"),
     *                         @OA\Property(property="Description", type="string", example="Assemble the puzzle"),
     *                         @OA\Property(property="PathImg", type="string", format="binary"),
     *                         @OA\Property(property="Clue", type="string", example="Solve the mystery image"),
     *                         @OA\Property(property="Rows", type="integer", example=4),
     *                         @OA\Property(property="Cols", type="integer", example=4),
     *                         @OA\Property(property="AutomaticHelp", type="boolean", example=false),
     *                         @OA\Property(property="Difficulty", type="string", example="Hard"),
     *                         @OA\Property(property="Activated", type="boolean", example=true),
     *                         @OA\Property(property="Visibility", type="string", example="Public"),
     *                         @OA\Property(property="Settings", type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="Key", type="string", example="time_limit"),
     *                                 @OA\Property(property="Value", type="string", example="120")
     *                             )
     *                         )
     *                     ),
     *                     @OA\Schema(
     *                         required={"Rows", "Cols", "Words", "Settings"},
     *                         @OA\Property(property="Name", type="string", example="Word Puzzle"),
     *                         @OA\Property(property="Description", type="string", example="Find hidden words"),
     *                         @OA\Property(property="Rows", type="integer", example=5),
     *                         @OA\Property(property="Cols", type="integer", example=5),
     *                         @OA\Property(property="Words", type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="Word", type="string", example="CAT"),
     *                                 @OA\Property(property="Orientation", type="string", example="HR")
     *                             )
     *                         ),
     *                         @OA\Property(property="Difficulty", type="string", example="Medium"),
     *                         @OA\Property(property="Activated", type="boolean", example=true),
     *                         @OA\Property(property="Visibility", type="string", example="Public"),
     *                         @OA\Property(property="Settings", type="array",
     *                             @OA\Items(
     *                                 @OA\Property(property="Key", type="string", example="max_words"),
     *                                 @OA\Property(property="Value", type="string", example="15")
     *                             )
     *                         )
     *                     )
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Hangman game created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 @OA\Property(
     *                     property="gameType",
     *                     type="array",
     *                     @OA\Items(type="string", example="The gameType field is required.")
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error creating game",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error creating game: Unexpected error")
     *         )
     *     )
     * )
     */
    public function createGame(int $userId, Request $request): JsonResponse
    {
        try {
            // Log para depuración de puzzle
            if ($request->input('gameType') === 'puzzle') {
                log::info('Puzzle createGame request', [
                    'userId' => $userId,
                    'body' => $request->all()
                ]);
            }
            $validatedData = $request->validate([
                'gameType' => 'required|string|in:hangman,memory,puzzle,solve_the_word',
                'data' => 'required|array'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error('Error de validación', 422, $e->errors());
        }

        $gameType = $validatedData['gameType'];
        $data = $validatedData['data'];

        try {
            $message = $this->gameService->createByGameType($userId, $gameType, $data);
            return ApiResponse::success($message, 'Game created successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error creating game: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/game/report/{gameInstanceId}",
     *     operationId="reportGame",
     *     tags={"Games"},
     *     summary="Get game session report by game instance",
     *     description="Generates a report of game sessions for a specific game instance, including total sessions, total minutes played, and average minutes per session per user and month.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         description="ID of the game instance (ProgrammingGameId) for which the report is generated",
     *         required=true,
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game session report generated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Game session report generated successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(property="user", type="string", example="John Doe"),
     *                     @OA\Property(property="month_name", type="string", example="March"),
     *                     @OA\Property(property="year", type="integer", example=2024),
     *                     @OA\Property(property="total_sessions", type="integer", example=5),
     *                     @OA\Property(property="total_minutes_played", type="integer", example=150),
     *                     @OA\Property(property="avg_minutes_per_session", type="number", format="float", example=30.0)
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error generating report",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error generating report: Some error message")
     *         )
     *     )
     * )
     */
    public function reportGame(int $gameInstanceId)
    {
        try {
            $report = $this->gameService->reportByGame($gameInstanceId);
            return ApiResponse::success($report, 'Game session report generated successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error generating report: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/game/settings/{gameInstanceId}",
     *     operationId="getSettingsGame",
     *     tags={"Games"},
     *     summary="Get the complete game configuration for a game instance",
     *     description="Retrieves the full configuration for a game instance. The response includes base game details and, only if available, specific configurations for Hangman, Memory, Puzzle, SolveTheWord, general game settings, and optionally all programmings with assessment status.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         description="ID of the game instance to retrieve settings for",
     *         required=true,
     *         @OA\Schema(type="integer", example=15)
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="query",
     *         description="ID of the user to check if assessed",
     *         required=true,
     *         @OA\Schema(type="integer", example=23)
     *     ),
     *     @OA\Parameter(
     *         name="withProgrammings",
     *         in="query",
     *         description="Include all programmings and their assessment status",
     *         required=false,
     *         @OA\Schema(type="boolean", example=true)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Game settings retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Game settings retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="game_instance_id", type="integer", example=15),
     *                 @OA\Property(property="game_name", type="string", example="Puzzle Challenge"),
     *                 @OA\Property(property="game_description", type="string", example="Exciting puzzle game"),
     *                 @OA\Property(property="difficulty", type="string", example="Medium"),
     *                 @OA\Property(property="visibility", type="string", example="Public"),
     *                 @OA\Property(property="activated", type="boolean", example=true),
     *                 @OA\Property(property="assessed", type="boolean", example=true),
     *                 @OA\Property(
     *                     property="programmings",
     *                     type="array",
     *                     nullable=true,
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="id", type="integer", example=101),
     *                         @OA\Property(property="name", type="string", example="Reto 1 - Bucle for"),
     *                         @OA\Property(property="start_time", type="string", format="date-time", example="2025-06-28 10:00:00"),
     *                         @OA\Property(property="end_time", type="string", format="date-time", example="2025-06-28 11:00:00"),
     *                         @OA\Property(property="attempts", type="integer", example=3),
     *                         @OA\Property(property="maximum_time", type="integer", example=30),
     *                         @OA\Property(property="activated", type="boolean", example=true),
     *                         @OA\Property(property="assessed", type="boolean", example=false)
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="hangman_words",
     *                     type="array",
     *                     nullable=true,
     *                     @OA\Items(
     *                         @OA\Property(property="word", type="string", example="APPLE"),
     *                         @OA\Property(property="clue", type="string", example="A fruit"),
     *                         @OA\Property(property="presentation", type="string", example="standard")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="memory_pairs",
     *                     type="array",
     *                     nullable=true,
     *                     @OA\Items(
     *                         @OA\Property(property="mode", type="string", example="II"),
     *                         @OA\Property(property="path_image1", type="string", example="storage/memory/image1.png"),
     *                         @OA\Property(property="path_image2", type="string", example="storage/memory/image2.png"),
     *                         @OA\Property(property="description_image", type="string", example="A pair of animals")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="puzzle",
     *                     type="object",
     *                     nullable=true,
     *                     @OA\Property(property="path_img", type="string", example="storage/puzzle/image.png"),
     *                     @OA\Property(property="clue", type="string", example="Assemble the picture"),
     *                     @OA\Property(property="rows", type="integer", example=4),
     *                     @OA\Property(property="cols", type="integer", example=4),
     *                     @OA\Property(property="automatic_help", type="boolean", example=true)
     *                 ),
     *                 @OA\Property(
     *                     property="solve_the_word",
     *                     type="array",
     *                     nullable=true,
     *                     @OA\Items(
     *                         @OA\Property(property="word", type="string", example="DOG"),
     *                         @OA\Property(property="orientation", type="string", example="HR")
     *                     )
     *                 ),
     *                 @OA\Property(
     *                     property="settings",
     *                     type="array",
     *                     nullable=true,
     *                     @OA\Items(
     *                         @OA\Property(property="key", type="string", example="time_limit"),
     *                         @OA\Property(property="value", type="string", example="60")
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Game instance not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Game instance not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error retrieving game settings",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving game settings: Unexpected error")
     *         )
     *     )
     * )
     */
    public function getSettingsGame(Request $request, int $gameInstanceId): JsonResponse
    {
        try {
            // Validar parámetros requeridos
            $userId = $request->query('userId');
            if (!$userId) {
                return ApiResponse::error('Missing required parameter: userId', 400);
            }

            $withProgrammings = filter_var($request->query('withProgrammings', false), FILTER_VALIDATE_BOOLEAN);

            $settings = $this->gameService->getConfig($gameInstanceId, (int) $userId, $withProgrammings);

            return ApiResponse::success($settings, 'Game settings retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving game settings: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/game-sessions/{programmingGameId}/{studentId}",
     *     operationId="storeGameSession",
     *     tags={"Game Sessions"},
     *     summary="Crear una nueva sesión de juego",
     *     description="Crea una nueva sesión de juego para un usuario dado y una programación específica. También almacena el progreso del juego en formato JSON. La fecha y hora se generan automáticamente.",
     *     @OA\Parameter(
     *         name="programmingGameId",
     *         in="path",
     *         required=true,
     *         description="ID de la programación del juego",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="studentId",
     *         in="path",
     *         required=true,
     *         description="ID del estudiante que juega",
     *         @OA\Schema(type="integer", example=42)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         description="Datos de la sesión de juego",
     *         @OA\JsonContent(
     *             required={"Duration", "Won", "Progress"},
     *             @OA\Property(
     *                 property="Duration",
     *                 type="integer",
     *                 example=180,
     *                 description="Duración en segundos del juego"
     *             ),
     *             @OA\Property(
     *                 property="Won",
     *                 type="boolean",
     *                 example=true,
     *                 description="Indica si el estudiante ganó"
     *             ),
     *             @OA\Property(
     *                 property="Progress",
     *                 type="object",
     *                 description="Progreso del juego en formato JSON libre",
     *                 example={
     *                     "score": 2500,
     *                     "steps": {"first": "move-left", "second": "match"},
     *                     "finished": true
     *                 }
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Sesión de juego y progreso creados exitosamente",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Game session and progress created successfully. Session ID: 101"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación o datos incompletos",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Error: Duration is required; Progress must be a valid object;"
     *         )
     *     )
     * )
     */
    public function storeGameSession(Request $request, int $programmingGameId, int $studentId)
    {
        $message = $this->gameService->createGameSession(
            $programmingGameId,
            $studentId,
            $request->all()
        );

        return response($message);
    }

    /**
     * @OA\Get(
     *     path="/game-progress/{gameInstanceId}/{userId}",
     *     operationId="getGameProgressByGameAndUser",
     *     tags={"Game Progress"},
     *     summary="Obtener el progreso de juego por usuario e instancia",
     *     description="Devuelve el progreso de un usuario en un juego específico, tomando la última sesión registrada.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         required=true,
     *         description="ID de la instancia del juego",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario/jugador",
     *         @OA\Schema(type="integer", example=42)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Progreso encontrado exitosamente",
     *         @OA\JsonContent(
     *             type="object",
     *             example={
     *                 "score": 800,
     *                 "steps": {"1": "click", "2": "match"},
     *                 "finished": true
     *             }
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No se encontró progreso para ese usuario y juego",
     *         @OA\JsonContent(
     *             type="object",
     *             example={"message": "No progress found for the user's session."}
     *         )
     *     )
     * )
     */
    public function showProgressByGameAndUser(int $gameInstanceId, int $userId)
    {
        $result = $this->gameService->getGameProgressByInstanceAndUser($gameInstanceId, $userId);

        if (is_string($result)) {
            return response()->json(['message' => $result], 404);
        }

        return response()->json($result);
    }

    /**
     * @OA\Put(
     *     path="/game-sessions/{gameInstanceId}/{userId}",
     *     operationId="updateGameSessionByInstanceAndUser",
     *     tags={"Game Sessions"},
     *     summary="Actualizar la última sesión de juego de un usuario en una instancia de juego",
     *     description="Actualiza los datos de la última sesión registrada del usuario para una instancia de juego específica.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         required=true,
     *         description="ID de la instancia de juego",
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID del usuario/jugador",
     *         @OA\Schema(type="integer", example=42)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"Duration", "Won"},
     *             @OA\Property(property="Duration", type="integer", example=220, description="Duración en segundos del juego"),
     *             @OA\Property(property="Won", type="boolean", example=true, description="Indica si el jugador ganó")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Sesión de juego actualizada exitosamente",
     *         @OA\JsonContent(type="string", example="Game session updated successfully. Session ID: 101")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Error de validación o sesión no encontrada",
     *         @OA\JsonContent(type="string", example="Error: No session found for this user and game instance.")
     *     )
     * )
     */
    public function updateSessionByInstanceAndUser(Request $request, int $gameInstanceId, int $userId)
    {
        $message = $this->gameService->updateGameSessionByInstanceAndUser($gameInstanceId, $userId, $request->all());

        return response($message);
    }

}
