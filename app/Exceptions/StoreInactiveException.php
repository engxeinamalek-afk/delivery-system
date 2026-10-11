<?php

namespace App\Exceptions;

class StoreInactiveException extends BaseException
{
    protected int $statusCode = 422; // المتجر موجود ولكن غير نشط
}
