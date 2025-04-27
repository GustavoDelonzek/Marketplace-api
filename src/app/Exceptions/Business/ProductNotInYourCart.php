<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\BadRequestException;

class ProductNotInYourCart extends BadRequestException
{
    protected function getDefaultMessage(): string
    {
        return 'Product not in your cart';
    }
}
