<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreMemoryGameRequest",
 *     type="object",
 *     required={"GameInstanceId", "Mode", "PathImg1", "PathImg2", "DescriptionImg"},
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="integer",
 *         example="1",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="Mode",
 *         type="string",
 *         enum={"II", "ID"},
 *         example="II",
 *         description="The mode of the memory game"
 *     ),
 *     @OA\Property(
 *         property="PathImg1",
 *         type="string",
 *         example="/images/img1.jpg",
 *         description="The path to the first image"
 *     ),
 *     @OA\Property(
 *         property="PathImg2",
 *         type="string",
 *         example="/images/img2.jpg",
 *         description="The path to the second image"
 *     ),
 *     @OA\Property(
 *         property="DescriptionImg",
 *         type="string",
 *         example="A description of the images",
 *         description="A description for the images"
 *     )
 * )
 */
class StoreMemoryGameRequest extends FormRequest
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
            'Mode' => ['required', 'in:II,ID'],
            'PathImg1' => ['required', 'string', 'max:50'],
            'PathImg2' => ['required', 'string', 'max:50'],
            'DescriptionImg' => ['required', 'string', 'max:100'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'GameInstanceId.required' => 'The GameInstanceId field is required.',
            'GameInstanceId.exists' => 'The selected GameInstanceId is invalid.',
            'Mode.required' => 'The Mode field is required.',
            'Mode.in' => 'The Mode must be one of the following values: II, ID.',
            'PathImg1.required' => 'The PathImg1 field is required.',
            'PathImg1.string' => 'The PathImg1 must be a string.',
            'PathImg1.max' => 'The PathImg1 may not be greater than 50 characters.',
            'PathImg2.required' => 'The PathImg2 field is required.',
            'PathImg2.string' => 'The PathImg2 must be a string.',
            'PathImg2.max' => 'The PathImg2 may not be greater than 50 characters.',
            'DescriptionImg.required' => 'The DescriptionImg field is required.',
            'DescriptionImg.string' => 'The DescriptionImg must be a string.',
            'DescriptionImg.max' => 'The DescriptionImg may not be greater than 100 characters.',
        ];
    }
}
