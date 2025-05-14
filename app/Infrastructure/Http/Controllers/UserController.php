<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\UserDto;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\User\CreateUserUseCase;
use App\Application\UseCase\User\DeleteUserUseCase;
use App\Application\UseCase\User\FindUserByEmailUseCase;
use App\Application\UseCase\User\GetAllUsersUseCase;
use App\Application\UseCase\User\GetUserByIdUseCase;
use App\Application\UseCase\User\UpdateUserUseCase;
use App\Infrastructure\Http\Requests\StoreUserFindRequest;
use App\Infrastructure\Http\Requests\StoreUserRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="Operations related to users"
 * )
 */
class UserController extends Controller {
    use ApiResponse;
    private CreateUserUseCase $createUserUseCase;
    private GetAllUsersUseCase $getAllUsersUseCase;
    private GetUserByIdUseCase $getUserByIdUseCase;
    private UpdateUserUseCase $updateUserUseCase;
    private DeleteUserUseCase $deleteUserUseCase;
    private FindUserByEmailUseCase $findUserByEmailUseCase;

    public function __construct(
        CreateUserUseCase $createUserUseCase,
        GetAllUsersUseCase $getAllUsersUseCase,
        GetUserByIdUseCase $getUserByIdUseCase,
        UpdateUserUseCase $updateUserUseCase,
        DeleteUserUseCase $deleteUserUseCase,
        FindUserByEmailUseCase $findUserByEmailUseCase
    ) {
        $this->createUserUseCase = $createUserUseCase;
        $this->getAllUsersUseCase = $getAllUsersUseCase;
        $this->getUserByIdUseCase = $getUserByIdUseCase;
        $this->updateUserUseCase = $updateUserUseCase;
        $this->deleteUserUseCase = $deleteUserUseCase;
        $this->findUserByEmailUseCase = $findUserByEmailUseCase;
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
            return $this->errorResponse(2100);
        }
        return $this->successResponse($users, 2101);
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
            return $this->errorResponse(2102);
        }
        return $this->successResponse($user, 2103);
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
    // UserController.php
    public function createUser(StoreUserRequest $request) {
        $validatedData = $request->validated();
        $userDto = new UserDto($validatedData);
        $user = $this->createUserUseCase->execute($userDto);
        return $this->successResponse($user, 2105);
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
        return $this->successResponse($user, 2108);
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
            return $this->errorResponse(2109);
        }
        return $this->successResponse($user, 2110);
    }

    /**
     * @OA\Post(
     *     path="/users/findByEmail",
     *     tags={"Users"},
     *     summary="Find user by email",
     *     description="Finds a user by their email address.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreUserFindRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="User found",
    *         @OA\JsonContent(
    *             type="object",
    *             @OA\Property(property="Id", type="integer"),
    *             @OA\Property(property="Name", type="string"),
    *             @OA\Property(property="LastName", type="string")
    *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="User not found"
     *     )
     * )
     */
    // En el método findUserByEmail
    public function findUserByEmail(StoreUserFindRequest $request) {
        $validatedData = $request->only(['Email']);
        $email = $validatedData['Email'];
        $user = $this->findUserByEmailUseCase->execute($email);

        if (!$user) {
            return $this->errorResponse(2111);
        }

        // Devuelve más datos del usuario
        return $this->successResponse([
            'Id' => $user->Id,
            'Name' => $user->Name,
            'LastName' => $user->LastName,
            'Email' => $user->Email,
            'Gender' => $user->Gender->value,
            'CountryId' => $user->CountryId,
            'City' => $user->City,
            'Birthdate' => $user->Birthdate,
            'CreatedAt' => $user->CreatedAt,
            'gamesCount' => $user->user()->count()
        ], 2112);
    }
}
