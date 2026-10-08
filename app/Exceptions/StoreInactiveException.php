<?php

namespace App\Exceptions;

class StoreInactiveException extends BaseException
{
    protected int $statusCode = 404;
}
