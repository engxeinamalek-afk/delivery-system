<?php

namespace App\Exceptions;

class InvalidOrderException extends BaseException
{
    public function __construct(string $message = "", int $statusCode = 422)
    {
        $this->statusCode = $statusCode;

        parent::__construct($message);
    }
}