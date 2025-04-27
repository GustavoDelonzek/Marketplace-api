<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\BadRequestException;

class ProductStockIsNotEnoughException extends BadRequestException
{
    protected function getDefaultMessage(): string
    {
        return 'Product stock is not enough for this quantity';
    }
}
