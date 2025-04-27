<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\BadRequestException;

class NothingToUpdateException extends BadRequestException
{
    protected function getDefaultMessage(): string
    {
        return 'Nothing to update!';
    }
}
