<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreUserRequest",
 *     type="object",
 *     required={"Activated", "GoogleId", "Email", "Name", "LastName", "Gender", "Country", "City", "Birthdate", "CreatedAt"},
 *     @OA\Property(
 *         property="Activated",
 *         type="boolean",
 *         example=true,
 *         description="Indicates if the user is activated"
 *     ),
 *     @OA\Property(
 *         property="GoogleId",
 *         type="string",
 *         maxLength=255,
 *         example="google-id-123456",
 *         description="The Google ID of the user"
 *     ),
 *     @OA\Property(
 *         property="Email",
 *         type="string",
 *         format="email",
 *         maxLength=255,
 *         example="user@example.com",
 *         description="The email of the user"
 *     ),
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         maxLength=35,
 *         example="John",
 *         description="The first name of the user"
 *     ),
 *     @OA\Property(
 *         property="LastName",
 *         type="string",
 *         maxLength=35,
 *         example="Doe",
 *         description="The last name of the user"
 *     ),
 *     @OA\Property(
 *         property="Gender",
 *         type="string",
 *         enum={"M", "F", "O"},
 *         example="M",
 *         description="The gender of the user (M=Male, F=Female, O=Other)"
 *     ),
 *     @OA\Property(
 *         property="Country",
 *         type="integer",
 *         example=1,
 *         description="The ID of the user's country (must exist in the Country table)"
 *     ),
 *     @OA\Property(
 *         property="City",
 *         type="string",
 *         maxLength=40,
 *         example="New York",
 *         description="The city where the user resides"
 *     ),
 *     @OA\Property(
 *         property="Birthdate",
 *         type="string",
 *         format="date",
 *         example="1990-01-01",
 *         description="The birthdate of the user"
 *     ),
 *     @OA\Property(
 *         property="CreatedAt",
 *         type="string",
 *         format="date",
 *         example="2025-04-26",
 *         description="The date when the user was created"
 *     )
 * )
 */
class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Activated' => [
                'required',
                'boolean',
            ],
            'GoogleId' => [
                'required',
                'string',
                'max:255',
                'unique:Users,GoogleId'
            ],
            'Email' => [
                'required',
                'email',
                'max:255',
            ],
            'Name' => [
                'required',
                'string',
                'max:35',
            ],
            'LastName' => [
                'required',
                'string',
                'max:35',
            ],
            'Gender' => [
                'required',
                'string',
                'in:M,F,O',
            ],
            'Country' => [
                'required',
                'exists:Country,Id',
            ],
            'City' => [
                'required',
                'string',
                'max:40',
            ],
            'Birthdate' => [
                'required',
                'date',
            ],
            'CreatedAt' => [
                'required',
                'date',
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'Activated.required' => 'The activated field is required.',
            'Activated.boolean' => 'The activated field must be true or false.',
            'GoogleId.required' => 'The Google ID is required.',
            'GoogleId.string' => 'The Google ID must be a string.',
            'GoogleId.max' => 'The Google ID may not be greater than 255 characters.',
            'GoogleId.unique' => 'The Google ID has already been taken.',
            'Email.required' => 'The email is required.',
            'Email.email' => 'The email must be a valid email address.',
            'Email.max' => 'The email may not be greater than 255 characters.',
            'Name.required' => 'The name is required.',
            'Name.string' => 'The name must be a string.',
            'Name.max' => 'The name may not be greater than 35 characters.',
            'LastName.required' => 'The last name is required.',
            'LastName.string' => 'The last name must be a string.',
            'LastName.max' => 'The last name may not be grater than 35 characters',
            'Gender.required' => 'The gender is required.',
            'Gender.string' => 'The gender must be a string.',
            'Gender.in' => 'The gender must be one of the following values: M, F, O.',
            'Country.required' => 'The country is required.',
            'Country.exists' => 'The selected country is invalid.',
            'City.required' => 'The city is required.',
            'City.string' => 'The city must be a string.',
            'City.max' => 'The city may not be greater than 40 characters.',
            'Birthdate.required' => 'The birthdate is required.',
            'Birthdate.date' => 'The birthdate must be a valid date.',
            'CreatedAt.required' => 'The created at date is required.',
            'CreatedAt.date' => 'The created at date must be a valid date.',
        ];
    }
}
