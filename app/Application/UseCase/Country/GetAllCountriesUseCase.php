<?php
namespace App\Application\UseCase\Country;

use App\Domain\Repositories\CountryRepository;

class GetAllCountriesUseCase
{
    public function __construct(
        private CountryRepository $repository
    ) {}

    public function execute(): array
    {
        return $this->repository->getAllCountries();
    }
}