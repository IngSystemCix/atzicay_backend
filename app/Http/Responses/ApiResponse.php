<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;

class ApiResponse
{
    public static function success($data = null, string $message = 'Operación exitosa', int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }

    public static function error(string $message = 'Error de operación', int $code = 500, $data = null): JsonResponse
    {
        return response()->json([
            'success' => false,
            'code'    => $code,
            'message' => $message,
            'data'    => $data,
        ], $code);
    }
}
