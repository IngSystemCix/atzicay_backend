<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * @OA\Get(
     *     path="/user/profile/{userId}",
     *     operationId="getUserProfile",
     *     tags={"Users"},
     *     summary="Get User Profile",
     *     description="Retrieve the profile information of a user by their ID.",
     *     
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the user",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="User profile retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User profile retrieved successfully"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="name", type="string", example="Juan"),
     *                 @OA\Property(property="last_name", type="string", example="Romero"),
     *                 @OA\Property(property="gender", type="string", example="M"),
     *                 @OA\Property(property="birthdate", type="string", format="date", example="1998-04-15"),
     *                 @OA\Property(property="country", type="string", example="Peru"),
     *                 @OA\Property(property="city", type="string", example="Lima"),
     *                 @OA\Property(property="member_since", type="string", format="date-time", example="2023-01-20 14:30:00")
     *             )
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found"),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving user profile: Internal server error"),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     )
     * )
     */
    public function getUserProfile(int $userId): JsonResponse
    {
        try {
            $user = $this->userService->getUserById($userId);

            if (!$user) {
                return ApiResponse::error('User not found', 404);
            }

            return ApiResponse::success($user, 'User profile retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving user profile: ' . $e->getMessage(), 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/user/update/{userId}",
     *     operationId="updateUserProfile",
     *     tags={"Users"},
     *     summary="Update User Profile",
     *     description="Update the profile information of a user by their ID.",
     *     
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="ID of the user to update",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="name", type="string", maxLength=255, example="Juan"),
     *             @OA\Property(property="last_name", type="string", maxLength=255, example="Romero"),
     *             @OA\Property(property="gender", type="string", enum={"Male", "Female", "Other"}, example="Male"),
     *             @OA\Property(property="birthdate", type="string", format="date", example="1998-04-15"),
     *             @OA\Property(property="city", type="string", maxLength=255, example="Lima"),
     *             @OA\Property(property="country_id", type="integer", example=2)
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=200,
     *         description="User profile updated successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="message", type="string", example="User profile updated successfully"),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=404,
     *         description="User not found",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found"),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Validation failed."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="name", type="array", @OA\Items(type="string", example="The name field must be a string.")),
     *                 @OA\Property(property="gender", type="array", @OA\Items(type="string", example="The selected gender is invalid."))
     *             )
     *         )
     *     ),
     *     
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="An unexpected error occurred"),
     *             @OA\Property(property="data", type="object", nullable=true)
     *         )
     *     )
     * )
     */
    public function updateUserProfile(Request $request, int $userId): JsonResponse
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'gender' => 'nullable|string|in:Male,Female,Other',
            'birthdate' => 'nullable|date',
            'city' => 'nullable|string|max:255',
            'country_id' => 'nullable|integer|exists:country,Id',
        ]);

        $success = $this->userService->updateUserById($userId, $validatedData);

        if ($success) {
            return ApiResponse::success(null, 'User profile updated successfully');
        } else {
            return ApiResponse::error('User not found', 404);
        }
    }

    /**
     * @OA\Get(
     *     path="/user/id-by-email",
     *     summary="Obtiene el ID de un usuario a partir de su correo electrónico",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Correo electrónico del usuario",
     *         required=true,
     *         @OA\Schema(type="string", format="email")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="ID del usuario recuperado correctamente",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="user_id", type="integer", example=123)
     *             ),
     *             @OA\Property(property="message", type="string", example="User ID retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="User not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno del servidor",
     *         @OA\JsonContent(
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving user ID: Detalles del error")
     *         )
     *     )
     * )
     */
    public function getIdByEmail(string $email): JsonResponse
    {
        try {
            $userId = $this->userService->getIdByEmail($email);

            if ($userId === null) {
                return ApiResponse::error('User not found', 404);
            }

            return ApiResponse::success(['user_id' => $userId], 'User ID retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving user ID: ' . $e->getMessage(), 500);
        }
    }
}
