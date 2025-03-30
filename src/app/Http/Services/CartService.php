<?php

namespace App\Http\Services;

use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\ProductRepository;
use App\Models\Cart;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CartService{
    public function __construct(
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository,
        protected ProductRepository $productRepository)
    {
    }

    public function getAllCartsByUser($userId){
        return $this->cartRepository->getCartUser($userId);
    }

    public function showCart($userId){
        return $this->cartRepository->showCart($userId);
    }

    public function createCartItem(User $user,$cartItemData){
        if($this->productRepository->getStockProduct($cartItemData['product_id']) < $cartItemData['quantity']){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Product stock is not enough for this quantity'
                ], 400)
            );
        }

        if($this->cartItemRepository->productAlreadyInCart($user->cart->id, $cartItemData['product_id'])){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Product already in cart'
                ], 400)
            );
        }   

        $cartItemData['cart_id'] = $user->cart->id;
        $cartItemData['unit_price'] = $this->productRepository->getPriceProduct($cartItemData['product_id']);


        return $this->cartItemRepository->createItemCart($cartItemData);
    }
}
