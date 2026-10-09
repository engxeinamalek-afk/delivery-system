<?php
namespace App\Exceptions;

class InvalidDriverException extends BaseException
{
    protected int $statusCode = 403;
}