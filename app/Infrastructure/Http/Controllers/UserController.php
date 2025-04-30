<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\UserDto;
use App\Application\UseCase\User\CreateUserUseCase;
use App\Application\UseCase\User\DeleteUserUseCase;
use App\Application\UseCase\User\GetAllUsersUseCase;
use App\Application\UseCase\User\GetUserByIdUseCase;
use App\Application\UseCase\User\UpdateUserUseCase;
use App\Infrastructure\Http\Requests\StoreUserRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Operations related to users"
 * )
 */
class UserController extends Controller {
    private CreateUserUseCase $createUserUseCase;
    private GetAllUsersUseCase $getAllUsersUseCase;
    private GetUserByIdUseCase $getUserByIdUseCase;
    private UpdateUserUseCase $updateUserUseCase;
    private DeleteUserUseCase $deleteUserUseCase;

    public function __construct(
        CreateUserUseCase $createUserUseCase,
        GetAllUsersUseCase $getAllUsersUseCase,
        GetUserByIdUseCase $getUserByIdUseCase,
        UpdateUserUseCase $updateUserUseCase,
        DeleteUserUseCase $deleteUserUseCase
    ) {
        $this->createUserUseCase = $createUserUseCase;
        $this->getAllUsersUseCase = $getAllUsersUseCase;
        $this->getUserByIdUseCase = $getUserByIdUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->deleteUserUseCase = $deleteUserUseCase;
    }

    /**
     * @OA\Get(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Get all users",
     *     description="Retrieves all users.",
     *     @OA\Response(
     *         response=200,
     *         description="List of users",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No users found"
     *     ),
     * )
     */
    public function getAllUsers() {
        $users = $this->getAllUsersUseCase->execute();
        if (empty($users)) {
            return response()->json(['message' => 'No users found'], 404);
        }
        return response()->json($users, 200);
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Get user by ID",
     *     description="Retrieves a user by their ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User details",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     ),
     * )
     */
    public function getUserById($id) {
        $user = $this->getUserByIdUseCase->execute($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     tags={"Users"},
     *     summary="Create a new user",
     *     description="Creates a new user.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="User created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * )
     */
    public function createUser(StoreUserRequest $request) {
        $validatedData = $request->validated();
        $userDto = new UserDto($validatedData);
        $user = $this->createUserUseCase->execute($userDto);
        return response()->json($user, 201);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Update a user",
     *     description="Updates an existing user.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserDTO")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     * )
     */
    public function updateUser($id, StoreUserRequest $request) {
        $validatedData = $request->validated();
        $userDto = new UserDto($validatedData);
        $user = $this->updateUserUseCase->execute($id, $userDto);
        return response()->json($user, 200);
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     tags={"Users"},
     *     summary="Delete a user",
     *     description="Deletes a user by their ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User deleted successfully"
     *     ),
     *     @OA\Response(
     *        response=404,
     *        description="User not found"
     *     )
     * )
     */
    public function deleteUser($id) {
        $user = $this->deleteUserUseCase->execute($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json(['message' => 'User deleted successfully'], 200);
    }
}