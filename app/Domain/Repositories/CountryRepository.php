<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Country;

/**
 * Interface for managing countries in the repository.
 */
interface CountryRepository
{
    /**
     * Retrieves all countries.
     *
     * @return array The list of all countries.
     */
    public function getAllCountries(): array;

    /**
     * Retrieves a country by its ID.
     *
     * @param int $id The ID of the country to retrieve.
     * @return Country The retrieved country entity.
     */
    public function getCountryById(int $id): Country;

    /**
     * Creates a new country.
     *
     * @param array $data The data for creating the country.
     * @return Country The created country entity.
     */
    public function createCountry(array $data): Country;
}