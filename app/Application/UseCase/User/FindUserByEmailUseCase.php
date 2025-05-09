<?php
namespace App\Application\UseCase\User;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class FindUserByEmailUseCase {
    public function __construct(
        private UserRepository $repository
    ) {}

    public function execute(string $email): array {
        $user = $this->repository->findUserByEmail($email);

        if (empty($user)) {
            throw new \RuntimeException("User not found with email: $email");
        }

        return $user;
    }
}