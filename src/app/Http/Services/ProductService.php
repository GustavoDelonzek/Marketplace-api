<?php

namespace App\Http\Services;

use App\Http\Repositories\ProductRepository;

class ProductService{
    public function __construct(protected ProductRepository $productRepository)
    {
    }

    public function getAllProducts(){
        return $this->productRepository->getAllProducts();
    }

    public function createProduct(){
        //
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
