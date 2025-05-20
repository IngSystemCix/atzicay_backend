<?php

namespace App\Infrastructure\Http\Controllers;

use App\Domain\Enums\Gender;
use App\Infrastructure\Models\AuthUser;
use Auth0\SDK\Auth0;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login(Request $request)
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

            // Decodificar y validar el token
            $userInfo = $auth0->decode($request->id_token);

            if (!$userInfo) {
                \Log::error('Auth0 token verification failed: Invalid token');
                return response()->json(['error' => 'Token inválido o expirado'], 401);
            }

            // Obtener el payload del token (array con claims)
            if ($userInfo instanceof \Auth0\SDK\Token) {
                $payload = $userInfo->toArray();
            } else {
                $payload = (array) $userInfo;
            }

            $email = $payload['email'] ?? null;
            $name = $payload['name'] ?? '';

            if (!$email) {
                \Log::error('No se encontró correo electrónico en el token', ['payload' => $payload]);
                return response()->json(['error' => 'No se encontró correo electrónico en el token'], 400);
            }

            $user = AuthUser::firstOrCreate(
                ['email' => $email],
                [
                    'Activated' => true,
                    'Name' => $name,
                    'Email' => $email,
                    'LastName' => '',
                    'Gender' => Gender::OTHER,
                    'CountryId' => 1,
                    'City' => '',
                    'Birthdate' => '2000-01-01',
                    'CreatedAt' => now(),
                ]
            );

            // Generar token JWT interno
            $token = JWTAuth::fromUser($user);

            return $this->respondWithToken($token, $user);

        } catch (\Exception $e) {
            \Log::error('Auth0 token verification failed: ' . $e->getMessage());
            return response()->json(['error' => 'Error interno al verificar token'], 500);
        }
    }



    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        try {
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json(['message' => 'Sesión cerrada correctamente']);
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo cerrar la sesión'], 500);
        }
    }

    public function refresh()
    {
        try {
            $token = auth()->refresh();
            return $this->respondWithToken($token, auth()->user());
        } catch (JWTException $e) {
            return response()->json(['error' => 'No se pudo refrescar el token'], 401);
        }
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => $user,
        ]);
    }
}
