<?php
namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\ProgrammingService;
use GrahamCampbell\ResultType\Success;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProgrammingController extends Controller
{
    protected ProgrammingService $programmingService;

    public function __construct(ProgrammingService $programmingService)
    {
        $this->programmingService = $programmingService;
    }

    /**
     * @OA\Get(
     *     path="/my-programming-games/{userId}",
     *     operationId="myProgrammingGames",
     *     tags={"Programming Games"},
     *     summary="Get programming games by user with filters",
     *     description="Retrieve a list of programming games associated with a specific user, allowing filtering by game type, start and end date (exact or range). Pagination (limit & offset) is also supported.",
     *     
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="integer", example=3)
     *     ),
     *     @OA\Parameter(
     *         name="gameType",
     *         in="query",
     *         required=false,
     *         description="Type of the game (hangman, memory, puzzle, solve_the_word, or all)",
     *         @OA\Schema(type="string", example="puzzle")
     *     ),
     *     @OA\Parameter(
     *         name="startDate",
     *         in="query",
     *         required=false,
     *         description="Start date for the range filter (format: Y-m-d)",
     *         @OA\Schema(type="string", format="date", example="2024-06-01")
     *     ),
     *     @OA\Parameter(
     *         name="endDate",
     *         in="query",
     *         required=false,
     *         description="End date for the range filter (format: Y-m-d)",
     *         @OA\Schema(type="string", format="date", example="2024-06-30")
     *     ),
     *     @OA\Parameter(
     *         name="exactStartDate",
     *         in="query",
     *         required=false,
     *         description="Exact start date filter (format: Y-m-d)",
     *         @OA\Schema(type="string", format="date", example="2024-06-15")
     *     ),
     *     @OA\Parameter(
     *         name="exactEndDate",
     *         in="query",
     *         required=false,
     *         description="Exact end date filter (format: Y-m-d)",
     *         @OA\Schema(type="string", format="date", example="2024-06-20")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         required=false,
     *         description="Number of records to return",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         required=false,
     *         description="Number of records to skip",
     *         @OA\Schema(type="integer", example=0)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Programming games retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="My programming games retrieved successfully"),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 @OA\Property(property="total", type="integer", example=2),
     *                 @OA\Property(
     *                     property="data",
     *                     type="array",
     *                     @OA\Items(
     *                         type="object",
     *                         @OA\Property(property="game_instance_id", type="integer", example=5),
     *                         @OA\Property(property="programming_name", type="string", example="Intro to Loops"),
     *                         @OA\Property(property="type_game", type="string", example="puzzle"),
     *                         @OA\Property(property="name_game", type="string", example="Loop Puzzle"),
     *                         @OA\Property(property="start_time", type="string", format="date-time", example="2024-06-10 09:00:00"),
     *                         @OA\Property(property="end_time", type="string", format="date-time", example="2024-06-10 10:00:00"),
     *                         @OA\Property(property="attempts", type="integer", example=3),
     *                         @OA\Property(property="maximum_time", type="integer", example=600),
     *                         @OA\Property(property="status", type="boolean", example=true)
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error retrieving programming games",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving programming games: Unexpected error")
     *         )
     *     )
     * )
     */
    public function myProgrammingGames(int $userId): JsonResponse
    {
        $gameType = request()->query('gameType', 'all');
        $limit = (int) request()->query('limit', 10);
        $offset = (int) request()->query('offset', 0);
        $startDate = request()->query('startDate', null);
        $endDate = request()->query('endDate', null);
        $exactStartDate = request()->query('exactStartDate', null);
        $exactEndDate = request()->query('exactEndDate', null);
        $games = $this->programmingService->myProgrammingGames(
            $startDate,
            $endDate,
            $exactStartDate,
            $exactEndDate,
            $userId,
            $gameType,
            $limit,
            $offset
        );

        return ApiResponse::success($games, 'My programming games retrieved successfully');
    }

    /**
     * @OA\Put(
     *     path="/programming-game/status/{gameInstanceId}",
     *     operationId="setProgrammingGameStatus",
     *     tags={"Programming Games"},
     *     summary="Update the activation status of a Programming Game",
     *     description="Updates the 'Activated' status of a Programming Game associated with a given GameInstanceId.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"status"},
     *             @OA\Property(property="status", type="integer", enum={0, 1}, example=0, description="New status for the game: 0 = inactive, 1 = active")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Programming game status updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Programming game status updated successfully"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Programming game not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Programming game not found for this game instance")
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid request body",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid status value")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Unexpected error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Unexpected error occurred")
     *         )
     *     )
     * )
     */
    public function setProgrammingGameStatus(Request $request, int $gameInstanceId): JsonResponse
    {
        $status = $request->input('status');

        if (!in_array($status, [0, 1], true)) {
            return ApiResponse::error('Invalid status value', 400);
        }

        $result = $this->programmingService->setProgrammingGameStatus($gameInstanceId, $status);

        if ($result === 'Programming game not found for this game instance') {
            return ApiResponse::error($result, 404);
        }

        if ($result === 'Programming game status updated successfully') {
            return ApiResponse::success(null, $result);
        }

        return ApiResponse::error('Unexpected error occurred', 500);
    }

    /**
     * @OA\Post(
     *     path="/programming-game/create/{gameInstanceId}/{userId}",
     *     operationId="createProgrammingGame",
     *     tags={"Programming Games"},
     *     summary="Create a new Programming Game",
     *     description="Creates a new Programming Game for the given GameInstance and User.",
     *     
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         required=true,
     *         description="ID of the Game Instance",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the User (Programmer)",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"Name", "Activated", "StartTime", "EndTime", "Attempts", "MaximumTime"},
     *             @OA\Property(property="Name", type="string", example="Algorithm Challenge"),
     *             @OA\Property(property="Activated", type="boolean", example=true),
     *             @OA\Property(property="StartTime", type="string", format="date-time", example="2025-06-30 10:00:00"),
     *             @OA\Property(property="EndTime", type="string", format="date-time", example="2025-06-30 12:00:00"),
     *             @OA\Property(property="Attempts", type="integer", example=3),
     *             @OA\Property(property="MaximumTime", type="integer", example=120)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Programming game created successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Programming game created successfully"),
     *             @OA\Property(property="data", type="string", example="Programming game created successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="Name", type="array",
     *                     @OA\Items(type="string", example="The Name field is required.")
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
     *             @OA\Property(property="message", type="string", example="An error occurred while creating the programming game."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="exception", type="string", example="Detailed exception message here.")
     *             )
     *         )
     *     )
     * )
     */
    public function createProgrammingGame(int $gameInstanceId, int $userId, Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'Name' => 'required|string|max:255',
                'Activated' => 'required|boolean',
                'StartTime' => 'required|date',
                'EndTime' => 'required|date|after_or_equal:StartTime',
                'Attempts' => 'required|integer|min:1',
                'MaximumTime' => 'required|integer|min:0'
            ]);

            $message = $this->programmingService->createProgrammingGame($gameInstanceId, $userId, $validatedData);

            return ApiResponse::success(
                $message,
                'Programming game created successfully'
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return ApiResponse::error(
                'Validation failed.',
                422,
                $e->errors()
            );
        } catch (\Exception $e) {
            return ApiResponse::error(
                'An error occurred while creating the programming game.',
                500,
                ['exception' => $e->getMessage()]
            );
        }
    }
}