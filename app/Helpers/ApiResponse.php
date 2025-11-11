<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success(string $message = '', $data = null, int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'code'    => $status,
            'data'    => $data,
        ], $status);
    }

    public static function error(string $message = '', $type = null, $details = null, int $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code'    => $status,   
            'error'   => [
                'type'    => $type,
                'details' => $details
            ]
        ], $status);
    }
}
