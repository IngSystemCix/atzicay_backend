<?php

namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreGameSettingRequest",
 *     type="object",
 *     required={"GameInstanceId", "ConfigKey", "ConfigValue"},
 *     @OA\Property(
 *         property="GameInstanceId",
 *         type="string",
 *         example="1",
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="ConfigKey",
 *         type="string",
 *         example="difficulty",
 *         description="The configuration key of the game setting"
 *     ),
 *     @OA\Property(
 *         property="ConfigValue",
 *         type="string",
 *         example="hard",
 *         description="The configuration value of the game setting"
 *     )
 * )
 */
class StoreGameSettingRequest extends FormRequest
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
            'GameInstanceId' => ['required','string','exists:GameInstances,Id'],
            'ConfigKey' => ['required','string','exists:GameSettings,ConfigKey'],
            'ConfigValue' => ['required','string','exists:GameSettings,ConfigValue']
        ];
    }

    public function messages(): array
    {
        return [
            'GameInstanceId.required' => 'The GameInstanceId field is required.',
            'GameInstanceId.string' => 'The GameInstanceId field must be a string.',
            'GameInstanceId.exists' => 'The selected GameInstanceId is invalid.',
            'ConfigKey.required' => 'The ConfigKey field is required.',
            'ConfigKey.string' => 'The ConfigKey field must be a string.',
            'ConfigKey.exists' => 'The selected ConfigKey is invalid.',
            'ConfigValue.required' => 'The ConfigValue field is required.',
            'ConfigValue.string' => 'The ConfigValue field must be a string.',
            'ConfigValue.exists' => 'The selected ConfigValue is invalid.'
        ];
    }
}
