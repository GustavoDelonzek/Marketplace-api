<?php

namespace App\Http\Repositories;

use App\Models\Cart;
use App\Models\CartItem;

class CartItemRepository{
    public function createItemCart($cartItemData){
        return CartItem::create($cartItemData);
    }

    public function productAlreadyInCart($cartId, $productId){
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->exists();
    }

    public function updateQuantityCartItem($cartId, $cartItemData){
        return CartItem::where('cart_id', $cartId)->where('product_id', $cartItemData['product_id'])->update([
            'quantity' => $cartItemData['quantity']
        ]);
    }

    public function getCartItemsByCart($cartId){
        return CartItem::where('cart_id', $cartId)->get();
    }

    public function deleteCartItem($cartId, $productId){
        return CartItem::where('cart_id', $cartId)->where('product_id', $productId)->delete();
    }

    public function clearCart($cartId){
        return CartItem::where('cart_id', $cartId)->delete();
    }


}
