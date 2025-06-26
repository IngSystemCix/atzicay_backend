<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RatingController
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * @OA\Post(
     *     path="/rate-game/{gameInstanceId}/{userId}",
     *     operationId="valueRating",
     *     tags={"Ratings"},
     *     summary="Rate a game instance",
     *     description="Creates or updates a user's rating for a specific game instance.",
     *     @OA\Parameter(
     *         name="gameInstanceId",
     *         in="path",
     *         required=true,
     *         description="ID of the game instance",
     *         @OA\Schema(type="integer", example=12)
     *     ),
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the user rating the game",
     *         @OA\Schema(type="integer", example=5)
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"value"},
     *             @OA\Property(property="value", type="integer", example=4, description="Rating value (1 to 5)"),
     *             @OA\Property(property="comments", type="string", example="Muy divertido", description="Optional comments")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Rating processed successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="Rating created successfully"),
     *             @OA\Property(property="data", type="string", example=null)
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Missing or invalid data",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Invalid rating value")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error processing rating")
     *         )
     *     )
     * )
     */
    public function valueRating(Request $request, int $gameInstanceId, int $userId): JsonResponse
    {
        $value = $request->input('value');
        $comments = $request->input('comments');

        if (!is_numeric($value) || $value < 1 || $value > 5) {
            return ApiResponse::error('Invalid rating value. It must be an integer between 1 and 5.', 400);
        }

        try {
            $result = $this->ratingService->valueRating($gameInstanceId, $userId, (int) $value, (string) $comments);
            return ApiResponse::success(null, $result);
        } catch (\Exception $e) {
            return ApiResponse::error('Error processing rating: ' . $e->getMessage(), 500);
        }
    }

}