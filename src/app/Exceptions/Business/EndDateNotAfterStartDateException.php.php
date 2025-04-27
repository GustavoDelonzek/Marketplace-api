<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\BadRequestException;

class EndDateNotAfterStartDateException extends BadRequestException
{
    protected function getDefaultMessage(): string
    {
        return 'End date must be after start date';
    }
}
