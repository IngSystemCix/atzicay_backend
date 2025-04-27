<?php
namespace App\Application\UseCase\Country;

use App\Application\DTOs\CountryDTO;
use App\Application\Mappers\CountryMapper;
use App\Domain\Entities\Country;
use App\Domain\Repositories\CountryRepository;

class CreateCountryUseCase {
    public function __construct(
        private CountryRepository $repository
    ) {}

    public function execute(CountryDTO $dto): Country {
        $country = CountryMapper::toEntity($dto);
        return $this->repository->createCountry($country->toArray());
    }
}