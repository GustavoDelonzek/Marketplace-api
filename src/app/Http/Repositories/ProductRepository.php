<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository{
    public function getAllProducts(){
        return Product::query();
    }

    public function getAllProductsByCategory($categoryId){
        return Product::where('category_id', $categoryId)->get();
    }

    public function createProduct($productData){
        return Product::create($productData);
    }

    public function updateProduct($productId, $productData){
        return Product::where('id', $productId)->update($productData);
    }

    public function showProduct($productId){
        return Product::where('id', $productId)->first();
    }

    public function deleteProduct($productId){
        return Product::where('id', $productId)->delete();
    }

    public function getStockProduct($productId){
        return Product::findOrFail($productId)->stock;
    }

    public function getPriceProduct($productId){
        return Product::findOrFail($productId)->price;
    }

    public function updateStock($productId, $quantity){
        return Product::where('id', $productId)->update([
            'stock' => $quantity
        ]);
    }
}
