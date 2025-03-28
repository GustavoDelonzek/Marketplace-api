<?php

namespace App\Http\Repositories;

use App\Models\Discount;

class DiscountRepository{
    public function getAllDiscounts(){
        return Discount::all();
    }

    public function createDiscount($discountData){
        return Discount::create($discountData);
    }

    public function updateDiscount($discountId, $discountData){
        return Discount::where('id', $discountId)->update($discountData);
    }

    public function showDiscount($discountId){
        return Discount::findOrFail($discountId);
    }

    public function deletediscount($discountId){
        return Discount::where('id', $discountId)->delete();
    }

}
