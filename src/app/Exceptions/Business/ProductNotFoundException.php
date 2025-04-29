<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\NotFoundException;

class ProductNotFoundException extends NotFoundException
{
    protected function getDefaultMessage(): string
    {
        return 'Product not found';
    }
}
