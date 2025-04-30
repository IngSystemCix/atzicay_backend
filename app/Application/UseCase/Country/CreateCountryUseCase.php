<?php

namespace App\Application\UseCase\Country;

use App\Application\DTOs\CountryDTO;
use App\Application\Mappers\CountryMapper;
use App\Domain\Entities\Country;
use App\Domain\Repositories\CountryRepository;

/**
 * Use case for creating a new country.
 */
class CreateCountryUseCase {
    /**
     * Constructor for CreateCountryUseCase.
     *
     * @param CountryRepository $repository The repository for managing countries.
     */
    public function __construct(
        private CountryRepository $repository
    ) {}

    /**
     * Executes the use case to create a new country.
     *
     * @param CountryDTO $dto The data transfer object containing country details.
     * @return Country The created country entity.
     */
    public function execute(CountryDTO $dto): Country {
        $country = CountryMapper::toEntity($dto);
        $this->repository->createCountry(CountryMapper::toArray($country));
        return $country;
    }
}