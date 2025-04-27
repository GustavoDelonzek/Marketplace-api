<?php

namespace App\Exceptions\Business;

use App\Exceptions\Http\BadRequestException;

class CouponNotExpired extends BadRequestException
{
    protected function getDefaultMessage(): string
    {
        return 'Coupon not deleted or expired';
    }
}
