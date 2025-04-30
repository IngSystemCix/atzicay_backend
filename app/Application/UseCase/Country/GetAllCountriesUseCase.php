<?php
namespace App\Application\UseCase\Country;

use App\Domain\Repositories\CountryRepository;

/**
 * Use case for retrieving all countries.
 */
class GetAllCountriesUseCase
{
    /**
     * Constructor for GetAllCountriesUseCase.
     *
     * @param CountryRepository $repository The repository for managing countries.
     */
    public function __construct(
        private CountryRepository $repository
    ) {}

    /**
     * Executes the use case to retrieve all countries.
     *
     * @return array The list of all countries.
     */
    public function execute(): array
    {
        return $this->repository->getAllCountries();
    }
}