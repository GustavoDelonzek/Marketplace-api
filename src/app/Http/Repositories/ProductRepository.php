<?php

namespace App\Http\Repositories;

use App\Models\Product;

class ProductRepository{
    public function getAllProducts(){
        return Product::with('category', 'discounts')->get();
    }

    public function getAllProductsByCategory($categoryId){
        return Product::with('category', 'discounts')->where('category_id', $categoryId)->get();
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

    public function deleteProduct($productId){
        return Product::where('id', $productId)->delete();
    }

    public function getStockProduct($productId){
        return Product::findOrFail($productId)->stock;
    }

    public function getPriceProduct($productId){
        $product = Product::findOrFail($productId);
        if($product->discounts){
            $totalDiscount = $product->discounts->sum('discount_percentage');

            if($totalDiscount >= 60){
                $totalDiscount = 60;
            }

            return $product->price - ($product->price * $totalDiscount / 100);
        }
        return $product->price;
    }
}
