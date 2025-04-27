<?php

namespace App\Http\Services;

use App\Exceptions\Business\CouponNotExpired;
use App\Exceptions\Business\DiscountPercentageTooHighException;
use App\Exceptions\Business\EndDateNotAfterStartDateException;
use App\Exceptions\Business\NothingToUpdateException;
use App\Http\Repositories\CouponRepository;
use App\Http\Resources\CouponResource;
use Illuminate\Http\Exceptions\HttpResponseException;

class CouponService{
    public function __construct(protected CouponRepository $couponRepository)
    {
    }

    public function getAllCoupons(){
        $coupons = $this->couponRepository->getAllCoupons();
        return CouponResource::collection($coupons);
    }

    public function createCoupon(array $couponData){


        if($couponData['discount_percentage'] > 60){
            throw new DiscountPercentageTooHighException();
        }

        return $this->couponRepository->createCoupon($couponData);
    }

    public function showCoupon(int $couponId){
        $coupon = $this->couponRepository->showCoupon($couponId);
        return new CouponResource($coupon);
    }

    public function updateCoupon($couponId, $couponData){
        $couponDatabase = $this->couponRepository->showCoupon($couponId);


        $start_date = $couponData['start_date'] ?? null;
        $end_date = $couponData['end_date'] ?? null;

        if(!$start_date && $end_date && $end_date <= $couponDatabase->start_date){
            throw new EndDateNotAfterStartDateException();
        }

        if(empty($couponData)){
            throw new NothingToUpdateException();
        }

        return $this->couponRepository->updateCoupon($couponId, $couponData);
    }

    public function deleteCoupon($couponId){
        return $this->couponRepository->deleteCoupon($couponId);
    }

    public function getDisabledCoupons(){
        $disabledCoupons = $this->couponRepository->getDisabledCoupons();
        return CouponResource::collection($disabledCoupons);
    }

    public function renewCoupon(string $couponId, $couponData){
        $couponDatabase = $this->couponRepository->getCouponDisabled($couponId);

        if($couponDatabase->deleted_at == null){
            throw new CouponNotExpired();
        }

        $couponData['deleted_at'] = null;

        return $this->couponRepository->renewCoupon($couponId, $couponData);
    }

}
