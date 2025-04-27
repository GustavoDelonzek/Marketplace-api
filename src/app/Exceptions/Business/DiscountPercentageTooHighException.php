<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\BadRequestException;

class DiscountPercentageTooHighException extends BadRequestException
{
    protected function getDefaultMessage(): string
    {
        return 'Discount percentage is too high, max is 60%';
    }
}
