<?php

namespace App\Http\Controllers;

use App\Models\AuthUser;
use Auth0\SDK\Auth0;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/auth/generate-token",
     *     tags={"Authentication"},
     *     summary="Generates JWT token from Auth0 ID token",
     *     description="Validates an Auth0 ID token and returns a JWT token for internal use.",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"id_token"},
     *             @OA\Property(property="id_token", type="string", example="eyJz93a...k4laUWw")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Token generated successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="jwt_token_example"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600),
     *             @OA\Property(property="user", type="object",
     *                 @OA\Property(property="Id", type="integer", example=1),
     *                 @OA\Property(property="Email", type="string", example="user@example.com"),
     *                 @OA\Property(property="Name", type="string", example="John"),
     *                 @OA\Property(property="LastName", type="string", example="Doe"),
     *                 @OA\Property(property="Gender", type="string", example="other"),
     *                 @OA\Property(property="CountryId", type="integer", example=1),
     *                 @OA\Property(property="City", type="string", example="N/A"),
     *                 @OA\Property(property="Birthdate", type="string", format="date", example="2000-01-01"),
     *                 @OA\Property(property="CreatedAt", type="string", format="date-time", example="2024-06-21T12:34:56")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid token or missing email"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal error verifying token"
     *     )
     * )
     */
    public function generateToken(Request $request)
    {
        $request->validate([
            'id_token' => 'required|string',
        ]);

        try {
            $auth0 = new Auth0([
                'domain' => env('AUTH0_DOMAIN'),
                'clientId' => env('AUTH0_CLIENT_ID'),
                'clientSecret' => env('AUTH0_CLIENT_SECRET'),
                'persistUser' => false,
                'persistAccessToken' => false,
                'persistRefreshToken' => false,
                'cookieSecret' => env('AUTH0_COOKIE_SECRET'),
            ]);

            $userInfo = $auth0->decode($request->id_token);

            if (!$userInfo) {
                Log::error('Auth0 token verification failed: Invalid token');
                return response()->json(['error' => 'Token inválido o expirado'], 401);
            }

            $payload = $userInfo instanceof \Auth0\SDK\Token
                ? $userInfo->toArray()
                : (array) $userInfo;

            $email = $payload['email'] ?? null;
            $name = $payload['given_name'] ?? '';
            $familyName = $payload['family_name'] ?? '';

            if (!$email) {
                Log::error('No se encontró correo electrónico en el token', ['payload' => $payload]);
                return response()->json(['error' => 'No se encontró correo electrónico en el token'], 400);
            }

            $user = AuthUser::firstOrCreate(
                ['email' => $email],
                [
                    'Activated' => true,
                    'Name' => $name,
                    'Email' => $email,
                    'LastName' => $familyName,
                    'Gender' => 'other', // Valor string simple, sin enum
                    'CountryId' => 1,
                    'City' => 'N/A',
                    'Birthdate' => '2000-01-01',
                    'CreatedAt' => now(),
                ]
            );

            $token = JWTAuth::fromUser($user);

            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'user' => $user,
            ]);

        } catch (\Exception $e) {
            Log::error('Auth0 token verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al verificar token'], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/auth/refresh-token",
     *     tags={"Authentication"},
     *     summary="Refreshes JWT token",
     *     description="Generates a new JWT token using the refresh token mechanism.",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Token refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="access_token", type="string", example="new_jwt_token_example"),
     *             @OA\Property(property="token_type", type="string", example="bearer"),
     *             @OA\Property(property="expires_in", type="integer", example=3600)
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Failed to refresh token"
     *     )
     * )
     */
    public function refreshToken()
    {
        try {
            $token = auth()->refresh();
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo refrescar el token'], 401);
        }
    }
}
