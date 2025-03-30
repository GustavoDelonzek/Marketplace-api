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

    public function updateProduct(User $user, $productId, $productData){
        if($user->role !== 'admin' && $user->role !== 'moderator'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to update!'
            ], 400));
        }

        return $this->productRepository->updateProduct($productId, $productData);
    }

    public function updateStock(User $user, $productId, $productData){
        if($user->role !== 'admin'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        if(empty($productData)){
            throw new HttpResponseException(response()->json([
                'message' => 'Nothing to update!'
            ], 400));
        }

        return $this->productRepository->updateProduct($productId, $productData);
    }

    public function deleteProduct(User $user, $productId){
        if($user->role !== 'admin'){
            throw new HttpResponseException(response()->json([
                'message' => 'Permission denied for this action'
            ], 401));
        }

        return $this->productRepository->deleteProduct($productId);
    }

    public function getAllProductsByCategory($categoryId){
        return $this->productRepository->getAllProductsByCategory($categoryId);
    }
}
