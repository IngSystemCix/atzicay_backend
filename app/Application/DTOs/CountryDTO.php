<?php
namespace App\Application\DTOs;

/**
 * @OA\Schema(
 *     schema="CountryDTO",
 *     type="object",
 *     required={"name"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="Peru"
 *     )
 * )
 */
class CountryDTO
{
    public function __construct(
        public string $name,
    ) {}
}