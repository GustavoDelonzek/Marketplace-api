<?php

namespace App\Http\Repositories;

use App\Models\Cart;

class CartRepository{
    public function getCartUser($userId){
        return Cart::where('user_id', $userId)->first();
    }

    public function showCart($userId){
        return Cart::with('cartItems')->where('user_id', $userId)->first();
    }
}
