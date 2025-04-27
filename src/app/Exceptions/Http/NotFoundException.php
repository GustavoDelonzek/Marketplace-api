<?php

namespace App\Exceptions\Http;

use Exception;
use App\Exceptions\BaseApiException;

class NotFoundException extends BaseApiException
{
    protected function getDefaultMessage(): string
    {
        return 'Resource not found';
    }

    protected function getDefaultStatusCode(): int
    {
        return 404;
    }
}
