<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


/**
 * @OA\Schema(
 *     schema="StoreCountryRequest",
 *     type="object",
 *     required={"Name"},
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         maxLength=56,
 *         example="Peru",
 *         description="The name of the country"
 *     )
 * )
 */
class StoreCountryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'Name' => [
                'required',
                'string',
                'max:56',
                'unique:Country,Name'
            ],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'Name.required' => 'The Name field is required.',
            'Name.string' => 'The Name field must be a string.',
            'Name.max' => 'The Name field must not exceed 56 characters.',
            'Name.unique' => 'The Name field must be unique.',
        ];
    }
}
