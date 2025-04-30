<?php
namespace App\Application\DTOs;

use App\Domain\Enums\Gender;

/**
 * @OA\Schema(
 *     schema="UserDTO",
 *     type="object",
 *     required={"Activated", "GoogleId", "Email", "Name", "LastName", "Gender", "Country", "City", "Birthdate", "CreatedAt"},
 *     @OA\Property(property="Activated", type="boolean"),
 *     @OA\Property(property="GoogleId", type="string"),
 *     @OA\Property(property="Email", type="string", format="email"),
 *     @OA\Property(property="Name", type="string"),
 *     @OA\Property(property="LastName", type="string"),
 *     @OA\Property(property="Gender", type="string", enum={"M", "F", "O"}),
 *     @OA\Property(property="Country", type="integer", description="ID of the country"),
 *     @OA\Property(property="City", type="string", description="City of the user"),
 *     @OA\Property(property="Birthdate", type="string", format="date", description="Birthdate of the user"),
 * )
 */
class UserDto {
    public bool $Activated;
    public string $GoogleId;
    public string $Email;
    public string $Name;
    public string $LastName;
    public Gender $Gender;
    public int $Country;
    public string $City;
    public string $Birthdate;

    public function __construct(array $data) {
        $this->Activated = $data['Activated'];
        $this->GoogleId = $data['GoogleId'];
        $this->Email = $data['Email'];
        $this->Name = $data['Name'];
        $this->LastName = $data['LastName'];
        $this->Gender = Gender::from($data['Gender']);
        $this->Country = $data['Country'];
        $this->City = $data['City'];
        $this->Birthdate = $data['Birthdate'];
    }
}