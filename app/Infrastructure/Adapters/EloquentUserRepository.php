<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class EloquentUserRepository implements UserRepository {
    
    public function createUser(array $data): User {
        return User::create([
            'Activated' => $data['Activated'],
            'GoogleId' => $data['GoogleId'],
            'Email'=> $data['Email'],
            'Name' => $data['Name'],
            'LastName' => $data['LastName'],
            'Gender'=> $data['Gender'],
            'Country'=> $data['Country'],
            'City'=> $data['City'],
            'Birthdate'=> $data['Birthdate'],
            'CreatedAt' => now(),
        ]);
    }
    public function getAllUsers(): array {
        return User::all()->toArray();
    }

    public function getUserById(int $id): User {
        $user = User::find($id);

        if (!$user) {
            throw new \RuntimeException("User not found with ID: $id");
        }

        return $user;
    }

    public function updateUser(int $id, array $data): User {
        $user = User::find($id);

        if (!$user) {
            throw new \RuntimeException("User not found with ID: $id");
        }
        $user->update([
            'Activated' => $data['Activated'],
            'GoogleId' => $data['GoogleId'],
            'Email'=> $data['Email'],
            'Name' => $data['Name'],
            'LastName' => $data['LastName'],
            'Gender'=> $data['Gender'],
            'Country'=> $data['Country'],
            'City'=> $data['City'],
            'Birthdate'=> $data['Birthdate'],
            'CreatedAt' => now(),
        ]);
        return $user;
    }

    public function deleteUser(int $id): User {
        $user = User::findOrFail($id);

        $user->Activated = false;
        $user->save();

        return $user;
    }
}