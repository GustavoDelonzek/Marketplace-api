<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\NotFoundException;

class ImageNotFoundException extends NotFoundException
{
    protected function getDefaultMessage(): string
    {
        return 'Image not found';
    }
}
