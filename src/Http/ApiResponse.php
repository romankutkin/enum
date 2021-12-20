<?php

declare(strict_types=1);

namespace App\Http;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse
{
    public static function create(int $status = 200, array $headers = [], array $content = [], bool $json = false): JsonResponse
    {
        return new JsonResponse($content, $status, $headers, $json);
    }
}
