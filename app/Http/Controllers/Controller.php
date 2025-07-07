<?php

namespace App\Http\Controllers;

abstract class Controller
{
    /**
     * Return a success JSON response.
     *
     * @param mixed $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data, $status = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
        ], $status);
    }

    /**
     * Return an error JSON response.
     *
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message, $status = 400)
    {
        return response()->json([
            'success' => false,
            'message' => $message,
        ], $status);
    }
}