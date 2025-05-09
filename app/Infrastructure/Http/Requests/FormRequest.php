<?php
namespace App\Infrastructure\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

abstract class FormRequest extends BaseFormRequest
{
    private const PATH_COUNTRIES = 'POST:api/atzicay/v1/countries';
    private const PATH_USERS = 'POST:api/atzicay/v1/users';
    private const PATH_USERS_PATTERN = 'PUT:api/atzicay/v1/users/*';
    private const PATH_GAME_INSTANCES = 'POST:api/atzicay/v1/game-instances';
    private const PATH_GAME_INSTANCES_PATTERN = 'PUT:api/atzicay/v1/game-instances/*';
    private const PATH_PROGRAMMING_GAMES = 'POST:api/atzicay/v1/programming-games';
    private const PATH_PROGRAMMING_GAMES_PATTERN = 'PUT:api/atzicay/v1/programming-games/*';
    private const PATH_ASSESSMENTS = 'POST:api/atzicay/v1/assessments';
    private const PATH_ASSESSMENTS_PATTERN = 'PUT:api/atzicay/v1/assessments/*';
    private const PATH_GAME_SETTINGS = 'POST:api/atzicay/v1/game-settings';
    private const PATH_GAME_SETTINGS_PATTERN = 'PUT:api/atzicay/v1/game-settings/*';
    private const PATH_HANGMAN = 'POST:api/atzicay/v1/hangman';
    private const PATH_HANGMAN_PATTERN = 'PUT:api/atzicay/v1/hangman/*';
    private const PATH_SOLVE_THE_WORD = 'POST:api/atzicay/v1/solve-the-word';
    private const PATH_SOLVE_THE_WORD_PATTERN = 'PUT:api/atzicay/v1/solve-the-word/*';
    private const PATH_MEMORY_GAME = 'POST:api/atzicay/v1/memory-game';
    private const PATH_MEMORY_GAME_PATTERN = 'PUT:api/atzicay/v1/memory-game/*';
    private const PATH_PUZZLE = 'POST:api/atzicay/v1/puzzles';
    private const PATH_PUZZLE_PATTERN = 'PUT:api/atzicay/v1/puzzles/*';
    private const PATH_GAME_SESSIONS = 'POST:api/atzicay/v1/game-sessions';
    private const PATH_GAME_SESSIONS_PATTERN = 'PUT:api/atzicay/v1/game-sessions/*';
    private const PATH_WORDS = 'POST:api/atzicay/v1/words';
    private const PATH_WORDS_PATTERN = 'PUT:api/atzicay/v1/words/*';
    private const PATH_GAME_PROGRESS = 'POST:api/atzicay/v1/game-progress';
    private const PATH_GAME_PROGRESS_PATTERN = 'PUT:api/atzicay/v1/game-progress/*';
    protected function failedValidation(Validator $validator)
    {
        $path = request()->path();
        $method = request()->method();

        $customCodes = [
            self::PATH_COUNTRIES => 2005,
            self::PATH_USERS => 2104,
            self::PATH_USERS_PATTERN => 2107,
            self::PATH_GAME_INSTANCES => 2204,
            self::PATH_GAME_INSTANCES_PATTERN => 2206,
            self::PATH_PROGRAMMING_GAMES => 2304,
            self::PATH_PROGRAMMING_GAMES_PATTERN => 2307,
            self::PATH_ASSESSMENTS => 2405,
            self::PATH_ASSESSMENTS_PATTERN => 2408,
            self::PATH_GAME_SETTINGS => 2504,
            self::PATH_GAME_SETTINGS_PATTERN => 2507,
            self::PATH_HANGMAN => 2607,
            self::PATH_HANGMAN_PATTERN => 2610,
            self::PATH_SOLVE_THE_WORD => 2704,
            self::PATH_SOLVE_THE_WORD_PATTERN => 2708,
            self::PATH_MEMORY_GAME => 2804,
            self::PATH_MEMORY_GAME_PATTERN => 2807,
            self::PATH_PUZZLE => 2904,
            self::PATH_PUZZLE_PATTERN => 2907,
            self::PATH_GAME_SESSIONS => 3004,
            self::PATH_GAME_SESSIONS_PATTERN => 3007,
            self::PATH_WORDS => 3104,
            self::PATH_WORDS_PATTERN => 3107,
            self::PATH_GAME_PROGRESS => 3204,
            self::PATH_GAME_PROGRESS_PATTERN => 3207,
            // otros endpoints...
        ];

        $matchedCode = 1003; // Código por defecto

        foreach ($customCodes as $pattern => $code) {
            [$expectedMethod, $expectedPath] = explode(':', $pattern);

            if ($method === $expectedMethod && fnmatch($expectedPath, $path)) {
                $matchedCode = $code;
                break;
            }
        }

        $errorConfig = config('errors.' . $matchedCode, [
            'message' => 'Validation failed',
            'http_code' => 422,
        ]);

        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'code' => $matchedCode,
                'message' => $errorConfig['message'],
                'errors' => $validator->errors(),
            ], $errorConfig['http_code'])
        );
    }
}