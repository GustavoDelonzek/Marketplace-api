<?php

namespace App\Http\Services;

use App\Http\Repositories\DiscountRepository;
use Error;

class DiscountService{
    public function __construct(protected DiscountRepository $discountRepository)
    {
    }

    public function getAllDiscounts(){
        return $this->discountRepository->getAllDiscounts();
    }


    public function createDiscount($user, $discountData){
        if($user->role !== 'admin'){
            throw new Error('Permission denied for this action', 401);
        }

        return $this->discountRepository->createDiscount($discountData);
    }

    public function showDiscount(int $discountId){
        return $this->discountRepository->showDiscount($discountId);
    }




}
