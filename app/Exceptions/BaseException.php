<?php
namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseException extends Exception
{
    protected int $statusCode = 500;

    public function __construct(string $message = "")
    {
        parent::__construct($message, $this->statusCode);
    }

    public function render(Request $request): JsonResponse
    {
        return response()->json([
            'status'  => 'error',
            'message' => $this->getMessage(),
        ], $this->statusCode);
    }
}

