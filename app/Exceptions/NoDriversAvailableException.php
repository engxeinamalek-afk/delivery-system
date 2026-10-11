<?php
namespace App\Exceptions;

class NoDriversAvailableException extends BaseException{
    protected int $statusCode=422;
}