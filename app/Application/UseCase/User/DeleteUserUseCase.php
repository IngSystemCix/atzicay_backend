<?php
namespace App\Application\UseCase\User;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class DeleteUserUseCase
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(int $id): User
    {
        $user = $this->repository->getUserById($id);
        if (!$user) {
            throw new \RuntimeException("User not found for ID: $id");
        }

        return $this->repository->deleteUser($id);
    }
}