<?php
namespace App\Application\UseCase\User;

use App\Application\DTOs\UserDto;
use App\Application\Mappers\UserMapper;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class CreateUserUseCase
{
    public function __construct(
        private UserRepository $repository,
    ) {}

    public function execute(UserDto $dto): User
    {
        $user = UserMapper::toEntity($dto);
        $this->repository->createUser(UserMapper::toArray($user));
        return $user;
    }
}