<?php
namespace App\Exceptions;

use App\Traits\ApiResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
abstract class BaseException extends Exception
{
    use ApiResponse;
    protected int $statusCode = 500;

    public function __construct(string $message = "")
    {
        parent::__construct($message, $this->statusCode);
    }

    public function render(Request $request): JsonResponse
    {
        return $this->errorResponse(message:   "Process failed: Invalid domain operation.",
                                    errors:    $this->getMessage(),
                                    statusCode:$this->statusCode);
    }
}

