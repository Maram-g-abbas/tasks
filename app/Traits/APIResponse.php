<?php

// app/Traits/ApiResponse.php
namespace App\Traits;

trait ApiResponse
{
    protected function successResponse($data, $message = 'Success', $code = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $code);
    }

    protected function errorResponse($message, $code ,$error)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'eroor' => $error
        ], $code);
    }
}
