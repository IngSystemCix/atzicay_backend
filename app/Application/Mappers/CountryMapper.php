<?php
namespace App\Application\Mappers;

use App\Application\DTOs\CountryDTO;
use App\Domain\Entities\Country;

class CountryMapper {
    public static function toEntity(CountryDTO $dto): Country {
        return new Country([
            'name' => $dto->name,
        ]);
    }
    public static function toDTO(Country $country): CountryDTO {
        return new CountryDTO($country->name);
    }
}