<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository{
    public function getAllProducts(){
        return Product::with('category', 'discounts')->get();
    }

    public function createProduct($productData){
        return Product::create($productData);
    }

    public function updateProduct($productId, $productData){
        return Product::where('id', $productId)->update($productData);
    }

    public function showProduct($productId){
        return Product::findOrFail($productId)->load('category', 'discounts');
    }

    public function deletedProduct($productId){
        return Product::where('id', $productId)->delete();
    }
}
