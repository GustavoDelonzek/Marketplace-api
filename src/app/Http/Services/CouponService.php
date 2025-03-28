<?php

namespace App\Http\Services;

use App\Http\Repositories\CouponRepository;
use App\Models\User;
use Error;

class CouponService{
    public function __construct(protected CouponRepository $couponRepository)
    {
    }

    public function getAllCoupons(){
        return $this->couponRepository->getAllCoupons();
    }

    public function createCoupon(User $user,array $couponData){
        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action');
        }

        return $this->couponRepository->createCoupon($couponData);

    }

}
