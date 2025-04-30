<?php
namespace App\Infrastructure\Adapters;

use App\Domain\Entities\Country;
use App\Domain\Repositories\CountryRepository;

class EloquentCountryRepository implements CountryRepository
{
    /**
     * Creates a new country in the repository.
     *
     * @param array $data The data for creating the country.
     * @return Country The created country entity.
     */
    public function createCountry(array $data): Country
    {
        return Country::create([
            'Name' => $data['Name'],
        ]);
    }

    /**
     * Retrieves all countries from the repository.
     *
     * @return array The list of all countries.
     */
    public function getAllCountries(): array
    {
        return Country::all()->toArray();
    }

    /**
     * Retrieves a country by its ID from the repository.
     *
     * @param int $id The ID of the country to retrieve.
     * @return Country The retrieved country entity.
     * @throws \RuntimeException If the country is not found.
     */
    public function getCountryById(int $id): Country
    {
        $country = Country::find($id);

        if (!$country) {
            throw new \RuntimeException("Country not found with ID: $id");
        }

        return $country;
    }
}