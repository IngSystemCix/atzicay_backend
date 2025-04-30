<?php

namespace App\Infrastructure\Http\Requests;

/**
 * @OA\Schema(
 *     schema="StoreGameInstancesRequest",
 *     type="object",
 *     required={"Name", "Description", "ProfessorId", "Activated", "Difficulty", "Visibility"},
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         maxLength=40,
 *         example="Math Challenge",
 *         description="The name of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Description",
 *         type="string",
 *         maxLength=300,
 *         example="A fun and educational math challenge.",
 *         description="A brief description of the game instance"
 *     ),
 *     @OA\Property(
 *         property="ProfessorId",
 *         type="integer",
 *         example=1,
 *         description="The ID of the professor managing the game instance"
 *     ),
 *     @OA\Property(
 *         property="Activated",
 *         type="boolean",
 *         example=true,
 *         description="Whether the game instance is activated or not"
 *     ),
 *     @OA\Property(
 *         property="Difficulty",
 *         type="string",
 *         enum={"E", "M", "H"},
 *         example="M",
 *         description="The difficulty level of the game instance (E: Easy, M: Medium, H: Hard)"
 *     ),
 *     @OA\Property(
 *         property="Visibility",
 *         type="string",
 *         enum={"P", "R"},
 *         example="P",
 *         description="The visibility of the game instance (P: Public, R: Restricted)"
 *     )
 * )
 */
class StoreGameInstancesRequest extends FormRequest
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
            'Name' => ['required','string','max:40'],
            'Description' => ['required','string','max:300'],
            'ProfessorId' => ['required','integer','exists:Users,Id'],
            'Activated' => ['required','boolean'],
            'Difficulty' => ['required','string','in:E,M,H'],
            'Visibility' => ['required','string','in:P,R'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'Name.required' => 'The name field is required.',
            'Name.string' => 'The name must be a string.',
            'Name.max' => 'The name may not be greater than 40 characters.',
            'Description.required' => 'The description field is required.',
            'Description.string' => 'The description must be a string.',
            'Description.max' => 'The description may not be greater than 300 characters.',
            'ProfessorId.required' => 'The professor ID field is required.',
            'ProfessorId.integer' => 'The professor ID must be an integer.',
            'ProfessorId.exists' => 'The professor ID must exist in the Users table.',
            'Activated.required' => 'The activated field is required.',
            'Activated.boolean' => 'The activated field must be true or false.',
            'Difficulty.required' => 'The difficulty field is required.',
            'Difficulty.string' => 'The difficulty must be a string.',
            'Difficulty.in' => 'The difficulty must be one of the following values: E, M, H.',
            'Visibility.required' => 'The visibility field is required.',
            'Visibility.string' => 'The visibility must be a string.',
            'Visibility.in' => 'The visibility must be one of the following values: P, R.',
        ];
    }
}
