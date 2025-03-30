<?php

namespace App\Http\Repositories;

use App\Models\CartItem;

class CartItemRepository{
    public function createItemCart($cartItemData){
        return CartItem::create($cartItemData);
    }

    public function productAlreadyInCart($cartId, $productId){
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->exists();
    }
}
