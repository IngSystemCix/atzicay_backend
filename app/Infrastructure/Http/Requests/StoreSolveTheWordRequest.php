<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreSolveTheWordRequest",
 *     type="object",
 *     required={"GameInstanceId", "Rows", "Cols"},
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         example=1,
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Rows",
 *         type="integer",
 *         example=4,
 *         description="The number of rows in the puzzle grid"
 *     ),
 *     @OA\Property(
 *         property="Cols",
 *         type="integer",
 *         example=4,
 *         description="The number of columns in the puzzle grid"
 *     )
 * )
 */
class StoreSolveTheWordRequest extends FormRequest
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
            'GameInstanceId' => ['required', 'exists:GameInstances,Id'],
            'Rows' => ['required', 'integer', 'min:1'],
            'Cols' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get the custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'GameInstanceId.required' => 'The GameInstanceId field is required.',
            'GameInstanceId.exists' => 'The specified GameInstanceId does not exist in the GameInstances table.',
            'Rows.required' => 'The Rows field is required.',
            'Rows.integer' => 'The Rows field must be an integer.',
            'Rows.min' => 'The Rows field must be at least 1.',
            'Cols.required' => 'The Cols field is required.',
            'Cols.integer' => 'The Cols field must be an integer.',
            'Cols.min' => 'The Cols field must be at least 1.',
        ];
    }
}
