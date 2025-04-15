<?php

namespace App\Http\Services;

use App\Http\Repositories\DiscountRepository;
use App\Http\Traits\CanLoadRelationships;
use App\Models\User;
use Error;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Http;

class DiscountService{
    use CanLoadRelationships;
    private array $relations = ['product'];

    public function __construct(protected DiscountRepository $discountRepository)
    {
    }

    public function getAllDiscounts(){
        $discountQuery = $this->discountRepository->getAllDiscounts();

        $discount = $this->loadRelationships($discountQuery)->get();

        return $discount;
    }


    public function createDiscount(User $user, $discountData){
        if($user->role !== 'admin'){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Permission denied for this action',
                ], 401));
        }

        if($discountData['discount_percentage'] > 60){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Discount percentage must be less than 60%',
                ], 400));
        }

        return $this->discountRepository->createDiscount($discountData);
    }

    public function showDiscount(int $discountId){
        $discountQuery = $this->discountRepository->showDiscount($discountId);

        $discount = $this->loadRelationships($discountQuery);

        return $discount;
    }

    public function updateDiscount(User $user,int $discountId, $discountData){
        if($user->role !== 'admin'){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Permission denied for this action',
                ], 401));
        }

        $discountDatabase = $this->discountRepository->showDiscount($discountId);


        $start_date = $discountData['start_date'] ?? null;
        $end_date = $discountData['end_date'] ?? null;

        if(!$start_date && $end_date && $end_date <= $discountDatabase->start_date){
            throw new HttpResponseException(
                response()->json([
                    'message'=>'End date must be previous than start date'
                ], 400));
        }


        if(empty($discountData)){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Nothing to update!'
                ], 400));
        }

        return $this->discountRepository->updateDiscount($discountId, $discountData);

    }

    public function deleteDiscount(User $user, int $discountId){
        if($user->role !== 'admin'){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Permission denied for this action',
                ], 401));
        }
        return $this->discountRepository->deleteDiscount($discountId);
    }
}
