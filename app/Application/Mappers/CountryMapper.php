<?php
namespace App\Application\Mappers;

use App\Application\DTOs\CountryDTO;
use App\Domain\Entities\Country;

/**
 * Mapper class for converting between Country entities, DTOs, and arrays.
 */
class CountryMapper {
    /**
     * Maps a CountryDTO to a Country entity.
     *
     * @param CountryDTO $dto The CountryDTO to map.
     * @return Country The mapped Country entity.
     */
    public static function toEntity(CountryDTO $dto): Country {
        return new Country([
            'Name' => $dto->Name,
        ]);
    }

    /**
     * Maps a Country entity to a CountryDTO.
     *
     * @param Country $country The Country entity to map.
     * @return CountryDTO The mapped CountryDTO.
     */
    public static function toDTO(Country $country): CountryDTO {
        return new CountryDTO([
            'Name' => $country->Name,
        ]);
    }

    /**
     * Maps a Country entity to an associative array.
     *
     * @param Country $country The Country entity to map.
     * @return array<string, mixed> The mapped associative array.
     */
    public static function toArray(Country $country): array {
        return [
            'Id' => $country->Id,
            'Name' => $country->Name,
        ];
    }
}