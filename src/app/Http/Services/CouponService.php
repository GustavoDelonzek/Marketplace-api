<?php

namespace App\Http\Services;

use App\Http\Repositories\CouponRepository;
use App\Models\User;
use Error;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CouponService{
    public function __construct(protected CouponRepository $couponRepository)
    {
    }

    public function getAllCoupons(){
        return $this->couponRepository->getAllCoupons();
    }

    public function createCoupon(User $user,array $couponData){
        if($user->role !== 'admin'){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Permission denied for this action',
                ], 401));
        }

        if($couponData['discount_percentage'] > 60){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Discount percentage must be less than 60%',
                ], 400));
        }

        return $this->couponRepository->createCoupon($couponData);
    }

    public function showCoupon(int $couponId){
        return $this->couponRepository->showCoupon($couponId);
    }

    public function updateCoupon(User $user, $couponId, $couponData){
        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action', 401);
        }

        $couponDatabase = $this->couponRepository->showCoupon($couponId);


        $start_date = $couponData['start_date'] ?? null;
        $end_date = $couponData['end_date'] ?? null;

        if(!$start_date && $end_date && $end_date <= $couponDatabase->start_date){
            throw new HttpResponseException(
                response()->json([
                    'message'=>'End date must be previous than start date'
                ], 400)
            );
        }


        if(empty($couponData)){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Nothing to update!'
                ], 400)
            );
        }

        return $this->couponRepository->updateCoupon($couponId, $couponData);
    }

    public function deleteCoupon(User $user, $couponId){
        if($user->role !== 'admin'){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Permission denied for this action',
                ], 401));
        }

        return $this->couponRepository->deleteCoupon($couponId);
    }

}
