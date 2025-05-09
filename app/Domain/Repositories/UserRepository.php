<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepository
{
    public function getAllUsers(): array;
    public function getUserById(int $id): User;
    public function createUser(array $data): User;
    public function updateUser(int $id, array $data): User;
    public function deleteUser(int $id): User;
    public function findUserByEmail(string $email): array;
}