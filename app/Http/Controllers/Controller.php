<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

abstract class Controller extends \Illuminate\Routing\Controller
{
    /**
     * Standard JSON response
     */
    protected function respond($data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    /**
     * No content response
     */
    protected function noContent(): JsonResponse
    {
        return response()->json(null, 204);
    }
}
