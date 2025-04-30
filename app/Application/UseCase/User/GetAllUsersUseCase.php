<?php
namespace App\Application\UseCase\User;

use App\Domain\Repositories\UserRepository;

class GetAllUsersUseCase
{
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->getAllUsers();
    }
}