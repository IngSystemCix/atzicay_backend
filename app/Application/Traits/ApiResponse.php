<?php

namespace App\Application\Traits;

trait ApiResponse
{
    public function successResponse($data = [], $customCode = 2000)
    {
        $success = config('errors.' . $customCode);

        if (!$success) {
            $success = [
                'message' => 'Success',
                'http_code' => 200,
            ];
        }

        return response()->json([
            'status' => 'success',
            'code' => $customCode,
            'message' => $success['message'],
            'data' => $data,
        ], $success['http_code']);
    }


    public function errorResponse($errorCode, $extra = [])
    {
        $error = config('errors.' . $errorCode);
        if (!$error) {
            $error = [
                'message' => 'Error desconocido.',
                'http_code' => 500,
            ];
        }

        return response()->json([
            'status' => 'error',
            'code' => $errorCode,
            'message' => $error['message'],
            'errors' => $extra,
        ], $error['http_code']);
    }
}