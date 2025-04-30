<?php

namespace App\Infrastructure\Http\Requests;

/**
 * @OA\Schema(
 *     schema="StoreProgrammingGameRequest",
 *     type="object",
 *     required={"GameInstancesId", "ProgrammerId", "name", "StartTime", "EndTime", "Attempts", "MaximumTime"},
 *     @OA\Property(
 *         property="GameInstancesId",
 *         type="integer",
 *         example=1,
 *         description="The ID of the game instance"
 *     ),
 *     @OA\Property(
 *         property="ProgrammerId",
 *         type="integer",
 *         example=2,
 *         description="The ID of the programmer"
 *     ),
 *     @OA\Property(
 *         property="Name",
 *         type="string",
 *         example="Programming Challenge",
 *         description="The Name of the programming game"
 *     ),
 *     @OA\Property(
 *        property="Activated",
 *        type="boolean",
 *        example=true,
 *        description="Whether the game is activated"
 *     ),
 *     @OA\Property(
 *         property="StartTime",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-26T09:00:00Z",
 *         description="The start time of the game"
 *     ),
 *     @OA\Property(
 *         property="EndTime",
 *         type="string",
 *         format="date-time",
 *         example="2025-04-26T10:00:00Z",
 *         description="The end time of the game"
 *     ),
 *     @OA\Property(
 *         property="Attempts",
 *         type="integer",
 *         example=3,
 *         description="The number of attempts allowed"
 *     ),
 *     @OA\Property(
 *         property="MaximumTime",
 *         type="integer",
 *         example=60,
 *         description="The maximum time allowed for the game in minutes"
 *     )
 * )
 */
class StoreProgrammingGameRequest extends FormRequest
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
            'GameInstancesId' => ['required', 'integer', 'exists:GameInstances,Id'],
            'ProgrammerId' => ['required', 'integer', 'exists:Users,Id'],
            'Name' => ['required', 'string', 'max:50'],
            'Activated' => ['boolean', 'required'],
            'StartTime' => ['required', 'date'],
            'EndTime' => ['required', 'date', 'after:StartTime'],
            'Attempts' => ['required', 'integer', 'min:1'],
            'MaximumTime' => ['required', 'integer', 'min:1'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array {
        return [
            'GameInstancesId.required' => 'The game instance ID is required.',
            'GameInstancesId.integer' => 'The game instance ID must be an integer.',
            'GameInstancesId.exists' => 'The selected game instance ID is invalid.',
            'ProgrammerId.required' => 'The programmer ID is required.',
            'ProgrammerId.integer' => 'The programmer ID must be an integer.',
            'ProgrammerId.exists' => 'The selected programmer ID is invalid.',
            'Name.required' => 'The Name is required.',
            'Name.string' => 'The Name must be a string.',
            'Name.max' => 'The Name may not be greater than 50 characters.',
            'Activated.required' => 'The activated status is required.',
            'Activated.boolean'=> 'The activated status must be true or false.',
            'StartTime.required' => 'The start time is required.',
            'StartTime.date' => 'The start time must be a valid date.',
            'EndTime.required' => 'The end time is required.',
            'EndTime.date' => 'The end time must be a valid date.',
            'EndTime.after' => 'The end time must be after the start time.',
            'Attempts.required' => 'The number of attempts is required.',
            'Attempts.integer' => 'The number of attempts must be an integer.',
            'Attempts.min' => 'The number of attempts must be at least 1.',
            'MaximumTime.required' => 'The maximum time is required.',
            'MaximumTime.integer' => 'The maximum time must be an integer.',
            'MaximumTime.min' => 'The maximum time must be at least 1.',
        ];
    }
}
