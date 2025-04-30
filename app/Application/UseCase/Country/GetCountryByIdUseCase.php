<?php

namespace App\Application\UseCase\Country;

use App\Domain\Entities\Country;
use App\Domain\Repositories\CountryRepository;

/**
 * Use case for retrieving a country by its ID.
 */
class GetCountryByIdUseCase {
    /**
     * Constructor for GetCountryByIdUseCase.
     *
     * @param CountryRepository $repository The repository for managing countries.
     */
    public function __construct(
        private CountryRepository $repository
    ) {}

    /**
     * Executes the use case to retrieve a country by its ID.
     *
     * @param int $id The ID of the country to retrieve.
     * @return Country The retrieved country entity.
     * @throws \RuntimeException If the country is not found.
     */
    public function execute(int $id): Country {
        $country = $this->repository->getCountryById($id);
        if (!$country) {
            throw new \RuntimeException("Country not found for ID: $id");
        }
        return $country;
    }
}