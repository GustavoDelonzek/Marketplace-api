<?php

namespace App\Exceptions\Http;

use App\Exceptions\BaseApiException;

class BadRequestException extends BaseApiException
{
    protected function getDefaultMessage(): string
    {
        return 'Bad request';
    }

    protected function getDefaultStatusCode(): int
    {
        return 400;
    }
}
