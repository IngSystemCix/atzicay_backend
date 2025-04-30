<?php
namespace App\Application\DTOs;

/**
 * @OA\Schema(
 *     schema="CountryDTO",
 *     type="object",
 *     required={"Name"},
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         example="Peru"
 *     )
 * )
 */
class CountryDTO
{
    public string $Name;

    public function __construct(array $data)
    {
        // Mapea manualmente
        $this->Name = $data['Name']; 
    }
}