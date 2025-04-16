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

    public function getDisabledCoupons(){
        return Coupon::withTrashed()->where('deleted_at', '<>', null)->get();
    }
    public function getCouponDisabled($couponId){
        return Coupon::withTrashed()->where('id', $couponId)->first();
    }

    public function renewCoupon($couponId, $couponData){
        return Coupon::withTrashed()->where('id', $couponId)->update($couponData);
    }
}
