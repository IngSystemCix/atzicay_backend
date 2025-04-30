<?php
namespace App\Application\UseCase\User;

use App\Application\DTOs\UserDto;
use App\Application\Mappers\UserMapper;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class UpdateUserUseCase
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(int $id, UserDto $data): User
    {
        $user = $this->repository->getUserById($id);
        if (!$user) {
            throw new \RuntimeException("User not found for ID: $id");
        }

        $updatedUser = UserMapper::toEntity($data);
        return $this->repository->updateUser($id, UserMapper::toArray($updatedUser));
    }
}