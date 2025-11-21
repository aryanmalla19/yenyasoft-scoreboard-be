<?php

declare(strict_types=1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    protected const HTTP_OK = 200;
    protected const HTTP_CREATED = 201;
    protected const HTTP_BAD_REQUEST = 400;
    protected const HTTP_UNAUTHORIZED = 401;
    protected const HTTP_FORBIDDEN = 403;
    protected const HTTP_NOT_FOUND = 404;
    protected const HTTP_SERVER_ERROR = 500;

    public function successResponse(string $message, mixed $data = null, int $statusCode = self::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status'  => true,
            'message' => $message,
            'data'    => $data,
        ], $statusCode);
    }

    public function errorResponse(string $message, mixed $errors = null, int $statusCode = self::HTTP_BAD_REQUEST): JsonResponse
    {
        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
        ], $statusCode);
    }

    public function createdResponse(string $message, mixed $data = null): JsonResponse
    {
        return $this->successResponse($message, $data, self::HTTP_CREATED);
    }

    public function customResponse(array $data, int $statusCode = self::HTTP_OK): JsonResponse
    {
        return response()->json($data, $statusCode);
    }
}
