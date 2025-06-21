<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CountryController extends Controller
{
    protected CountryService $countryService;

    public function __construct(CountryService $countryService)
    {
        $this->countryService = $countryService;
    }

    /**
     * @OA\Get(
     *     path="/country/all",
     *     operationId="getAllCountries",
     *     tags={"Countries"},
     *     summary="Get all countries",
     *     description="Returns a list of all countries sorted by name.",
     *     @OA\Response(
     *         response=200,
     *         description="Countries retrieved successfully",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=true),
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="Id", type="integer", example=1),
     *                     @OA\Property(property="Name", type="string", example="Peru")
     *                 )
     *             ),
     *             @OA\Property(property="message", type="string", example="Countries retrieved successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error retrieving countries",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="success", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Error retrieving countries: Some error message")
     *         )
     *     )
     * )
     */
    public function getAllCountries(): JsonResponse
    {
        try {
            $countries = $this->countryService->getAllCountries();
            return ApiResponse::success($countries, 'Countries retrieved successfully');
        } catch (\Exception $e) {
            return ApiResponse::error('Error retrieving countries: ' . $e->getMessage(), 500);
        }
    }
}