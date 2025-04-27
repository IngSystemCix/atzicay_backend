<?php
namespace App\Infrastructure\Http\Controllers;

use App\Application\DTOs\CountryDTO;
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
            return response()->json(['message' => 'No countries found'], 404);
        }
        return response()->json($countries, 200);
    }

    /**
     * @OA\Get(
     *     path="/countries/{id}",
     *     tags={"Countries"},
     *     summary="Get country by ID",
     *     description="Retrieves a country by its ID.",
     *     @OA\Parameter(
     *         name="id",
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
            return response()->json($country, 200);
        } catch (\RuntimeException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
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
        return response()->json($country, 201);
    }
}