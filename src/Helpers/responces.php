<?php
if (!function_exists(function: 'bhry98_response_success_with_data')) {
    function bhry98_response_success_with_data(array $data = [], string $message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            data: [
                'success' => true,
                'code' => 200,
                'data' => $data,
                'message' => $message,
                'note' => 'Success response with data',
            ]
        );
    }
}
if (!function_exists(function: 'bhry98_response_success_without_data')) {
    function bhry98_response_success_without_data(array $data = [], string $message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            data: [
                'success' => true,
                'code' => 404,
                'data' => $data,
                'message' => $message,
                'note' => 'Success response but no data found',
            ],
            status: 404
        );
    }
}
if (!function_exists(function: 'bhry98_response_validation_error')) {
    function bhry98_response_validation_error(array $data = [], string $message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            data: [
                'success' => false,
                'code' => 400,
                'data' => $data,
                'message' => $message,
                'note' => 'Field response with validation error',
            ],
            status: 400
        );
    }
}
if (!function_exists(function: 'bhry98_response_internal_error')) {
    function bhry98_response_internal_error(array $data = [], string $message = ''): \Illuminate\Http\JsonResponse
    {
        return response()->json(
            data: [
                'success' => false,
                'code' => 500,
                'data' => $data,
                'message' => $message,
                'note' => 'Field response with internal error',
            ],
            status: 500
        );
    }
}

