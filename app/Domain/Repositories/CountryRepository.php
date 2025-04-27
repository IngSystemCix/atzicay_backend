<?php
namespace App\Domain\Repositories;

use App\Domain\Entities\Country;

interface CountryRepository
{
    public function getAllCountries(): array;
    public function getCountryById(int $id): Country;
    public function createCountry(array $data): Country;
}