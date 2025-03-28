<?php

namespace App\Http\Services;

use App\Http\Repositories\DiscountRepository;
use App\Models\User;
use Error;

class DiscountService{
    public function __construct(protected DiscountRepository $discountRepository)
    {
    }

    public function getAllDiscounts(){
        return $this->discountRepository->getAllDiscounts();
    }


    public function createDiscount(User $user, $discountData){
        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action', 401);
        }

        return $this->discountRepository->createDiscount($discountData);
    }

    public function showDiscount(int $discountId){
        return $this->discountRepository->showDiscount($discountId);
    }

    public function updateDiscount(User $user,int $discountId, $discountData){
        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action', 401);
        }
        $discountDatabase = $this->discountRepository->showDiscount($discountId);


        $start_date = $discountData['start_date'] ?? null;
        $end_date = $discountData['end_date'] ?? null;

        if(!$start_date && $end_date && $end_date <= $discountDatabase->start_date){
            throw new Error('End date must be previous than start_date');
        }


        if(empty($discountData)){
            throw new Error('Nothing to update!', 204);
        }

        return $this->discountRepository->updateDiscount($discountId, $discountData);

    }



}
