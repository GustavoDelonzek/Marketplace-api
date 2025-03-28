<?php

namespace App\Http\Repositories;

use App\Models\Coupon;

class CouponRepository{
    public function getAllCoupons(){
        return Coupon::all();
    }

    public function createCoupon($couponData){
        return Coupon::create($couponData);
    }

    public function updateCoupon($couponId, $couponData){
        return Coupon::where('id', $couponId)->update($couponData);
    }

    public function showCoupon($couponId){
        return Coupon::findOrFail($couponId);
    }

    public function deleteCoupon($couponId){
        return Coupon::where('id', $couponId)->delete();
    }
}
