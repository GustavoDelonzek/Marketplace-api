<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductService{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getAllProducts(){
        return $this->productRepository->getAllProducts();
    }

    public function createProduct(User $user, $productData){
        if($user->role !== 'admin' && $user->role !== 'moderator'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to store!'
            ], 400));
        }

        return $this->productRepository->createProduct($productData);
    }

    public function showProduct($productId){
        return $this->productRepository->showProduct($productId);
    }

    public function updateProduct(){
        //
    }

    public function deleteProduct(){
        //
    }
}
