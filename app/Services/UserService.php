<?php

namespace App\Services;

use App\Models\User;

class UserService
{
    public function getUserById(int $userId)
    {
        return User::selectRaw("
            users.Name AS name,
            users.LastName AS last_name,
            users.Gender AS gender,
            users.Birthdate AS birthdate,
            country.Name AS country,
            users.City AS city,
            users.CreatedAt AS member_since
        ")
            ->leftJoin('country', 'country.Id', '=', 'users.CountryId') // Asumiendo que la FK correcta es 'CountryId'
            ->where('users.Id', $userId)
            ->first();
    }

    public function updateUserById(int $userId, array $data): bool
    {
        $user = User::find($userId);

        if (!$user) {
            return false; // Usuario no encontrado
        }

        // Actualizamos solo los campos permitidos
        $user->Name = $data['name'] ?? $user->Name;
        $user->LastName = $data['last_name'] ?? $user->LastName;
        
        // Convertir el género de texto completo a código de la base de datos
        if (isset($data['gender'])) {
            $genderMap = [
                'Male' => 'M',
                'Female' => 'F',
                'Other' => 'O',
                'Masculino' => 'M',
                'Femenino' => 'F',
                'Otro' => 'O',
                'M' => 'M',
                'F' => 'F',
                'O' => 'O'
            ];
            
            $user->Gender = $genderMap[$data['gender']] ?? $user->Gender;
        }
        
        $user->Birthdate = $data['birthdate'] ?? $user->Birthdate;
        $user->City = $data['city'] ?? $user->City;

        // Si llega CountryId (FK hacia la tabla Country)
        if (!empty($data['country_id'])) {
            $user->CountryId = $data['country_id'];
        }

        return $user->save();
    }

    public function getIdByEmail(string $email): ?int
    {
        return User::query()
            ->select('Id')
            ->where('Email', $email)
            ->value('Id');
    }

}