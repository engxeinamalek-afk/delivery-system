<?php

namespace App\Exceptions;

class InvalidOrderException extends BaseException
{
    protected int $statusCode = 403;
}