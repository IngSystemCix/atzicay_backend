<?php
namespace App\Application\Mappers;

use App\Application\DTOs\UserDto;
use App\Domain\Entities\User;

class UserMapper {
    
    public static function toEntity(UserDto $dto): User {
        return new User([
            'Activated' => $dto->Activated,
            'Email'=> $dto->Email,
            'Name' => $dto->Name,
            'LastName' => $dto->LastName,
            'Gender'=> $dto->Gender,
            'CountryId'=> $dto->CountryId,
            'City'=> $dto->City,
            'Birthdate'=> $dto->Birthdate,
        ]);
    }

    public static function toDTO(User $user): UserDto {
        return new UserDto([
            'Activated' => $user->Activated,
            'Email'=> $user->Email,
            'Name' => $user->Name,
            'LastName' => $user->LastName,
            'Gender'=> $user->Gender,
            'CountryId'=> $user->CountryId,
            'City'=> $user->City,
            'Birthdate'=> $user->Birthdate,
            'CreatedAt' => $user->CreatedAt,
        ]);
    }

    public static function toArray(User $user): array {
        return [
            'Id' => $user->Id,
            'Activated' => $user->Activated,
            'Email'=> $user->Email,
            'Name' => $user->Name,
            'LastName' => $user->LastName,
            'Gender'=> $user->Gender,
            'CountryId'=> $user->CountryId,
            'City'=> $user->City,
            'Birthdate'=> $user->Birthdate,
            'CreatedAt' => $user->CreatedAt,
        ];
    }

}