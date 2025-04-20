<?php

namespace App\Http\Services;

use App\Http\Repositories\DiscountRepository;
use App\Http\Resources\DiscountResource;
use App\Http\Traits\CanLoadRelationships;
use Illuminate\Http\Exceptions\HttpResponseException;

class DiscountService{
    use CanLoadRelationships;
    private array $relations = ['product'];

    public function __construct(protected DiscountRepository $discountRepository)
    {
    }

    public function getAllDiscounts(){
        $discountQuery = $this->discountRepository->getAllDiscounts();

        $discount = $this->loadRelationships($discountQuery)->get();

        return DiscountResource::collection($discount);
    }


    public function createDiscount($discountData){
        return $this->discountRepository->createDiscount($discountData);
    }

    public function showDiscount(int $discountId){
        $discountQuery = $this->discountRepository->showDiscount($discountId);

        $discount = $this->loadRelationships($discountQuery);

        return new DiscountResource($discount);
    }

    public function updateDiscount(int $discountId, $discountData){
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

    public function deleteDiscount(int $discountId){
        return $this->discountRepository->deleteDiscount($discountId);
    }
}
