<?php

namespace App\Application\UseCase\Country;

use App\Domain\Entities\Country;
use App\Domain\Repositories\CountryRepository;

class GetCountryByIdUseCase {
    public function __construct(
        private CountryRepository $repository
    ) {}

    public function execute(int $id): Country {
        $country = $this->repository->getCountryById($id);
        if (!$country) {
            throw new \RuntimeException("Country not found for ID: $id");
        }
        return $country;
    }
}