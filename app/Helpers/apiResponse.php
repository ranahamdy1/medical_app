<?php

use Illuminate\Http\JsonResponse;

if (!function_exists('api_response')) {
    function api_response(
        string $status = 'success', // success | fail
        string $message = '',
        mixed $data = null,
        int $statusCode = 200
    ): JsonResponse {

        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }
}
