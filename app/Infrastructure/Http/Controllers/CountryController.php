<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\CountryDTO;
use App\Application\Traits\ApiResponse;
use App\Application\UseCase\Country\CreateCountryUseCase;
use App\Application\UseCase\Country\GetAllCountriesUseCase;
use App\Application\UseCase\Country\GetCountryByIdUseCase;
use App\Infrastructure\Http\Requests\StoreCountryRequest;
use Illuminate\Routing\Controller;

/**
 * @OA\Tag(
 *     name="Countries",
 *     description="Operations related to countries"
 * )
 */
class CountryController extends Controller {
    use ApiResponse;
    private CreateCountryUseCase $createCountryUseCase;
    private GetAllCountriesUseCase $getAllCountriesUseCase;
    private GetCountryByIdUseCase $getCountryByIdUseCase;

    public function __construct(
        CreateCountryUseCase $createCountryUseCase,
        GetAllCountriesUseCase $getAllCountriesUseCase,
        GetCountryByIdUseCase $getCountryByIdUseCase
    ) {
        $this->createCountryUseCase = $createCountryUseCase;
        $this->getAllCountriesUseCase = $getAllCountriesUseCase;
        $this->getCountryByIdUseCase = $getCountryByIdUseCase;
    }

    /**
     * @OA\Get(
     *     path="/countries",
     *     tags={"Countries"},
     *     summary="Get all countries",
     *     description="Retrieves all countries.",
     *     @OA\Response(
     *         response=200,
     *         description="List of countries",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Country"))
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="No countries found"
     *     ),
     * )
     */
    public function getAllCountries() {
        $countries = $this->getAllCountriesUseCase->execute();
        if (empty($countries)) {
            return $this->errorResponse(2000);
        }
        return $this->successResponse($countries, 2001);
    }

    /**
     * @OA\Get(
     *     path="/countries/{id}",
     *     tags={"Countries"},
     *     summary="Get country by ID",
     *     description="Retrieves a country by its ID.",
     *     @OA\Parameter(
     *         name="Id",
     *         in="path",
     *         required=true,
     *         description="Country ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Country details",
     *         @OA\JsonContent(ref="#/components/schemas/Country")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Country not found"
     *     ),
     * )
     */
    public function getCountryById($id) {
        try {
            $country = $this->getCountryByIdUseCase->execute($id);
            return $this->successResponse($country, 2003);
        } catch (\RuntimeException $e) {
            return $this->errorResponse(2002, ['Id' => $id]);
        }
    }

    /**
     * @OA\Post(
     *     path="/countries",
     *     tags={"Countries"},
     *     summary="Create a new country",
     *     description="Creates a new country.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CountryDTO")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Country created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/Country")
     *     ),
     * )
     */
    public function createCountry(StoreCountryRequest $request) {
        $validatedData = $request->validated();
        $countryDTO = new CountryDTO($validatedData);
        $country = $this->createCountryUseCase->execute($countryDTO);
        return $this->successResponse($country, 2004);
    }
}