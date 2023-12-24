<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function isProd()
    {
        return env('APP_ENV') != 'local';
    }
    public function successResponse(array | null $data = null, string $message = "Success"): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], 200);
    }

    public function errorResponse(string $message = "Something went wrong", int $statusCode = 500, array | null $data = null): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], $statusCode);
    }

    public function exceptionResponse(Exception | null $e = null, String $message = "Something Went Wrong", int $statusCode = 500, null | array $data = null): JsonResponse
    {
        report($e);
        return response()->json([
            "message" => $this->isProd() ? $e->getMessage() : $message
        ], $statusCode);
    }
}
