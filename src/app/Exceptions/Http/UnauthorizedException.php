<?php

namespace App\Exceptions\Http;

use Exception;
use App\Exceptions\BaseApiException;


class UnauthorizedException extends BaseApiException
{
    protected function getDefaultMessage(): string
    {
        return 'Unauthorized for this action';
    }

    protected function getDefaultStatusCode(): int
    {
        return 401;
    }
}
