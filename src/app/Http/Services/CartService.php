<?php

namespace App\Http\Services;

use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\DiscountRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Resources\CartResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\Cart;
use App\Models\Discount;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;

class CartService{
    use CanLoadRelationships;
    private array $relations = ['cartItems.product'];

    public function __construct(
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository,
        protected ProductRepository $productRepository,
        protected DiscountRepository $discountRepository)
    {
    }

    public function getAllCartsByUser($userId){
        $cart = $this->cartRepository->getCartUser($userId);
        return new CartResource($cart);
    }

    public function showCart($userId){
        $cartQuery = $this->cartRepository->showCart($userId);
        $cart = $this->loadRelationships($cartQuery);
        return new CartResource($cart);
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

        $discountsPrice = $this->discountRepository->getDiscountsProduct($cartItemData['product_id']);
        $totalDiscount = $discountsPrice->sum('discount_percentage') ?? 0;

        if($totalDiscount >= 60){
            $totalDiscount = 60;
        }

        $normalPrice = $this->productRepository->getPriceProduct($cartItemData['product_id']);

        $cartItemData['unit_price'] = $normalPrice - ($normalPrice * $totalDiscount / 100);

        return $this->cartItemRepository->createItemCart($cartItemData);
    }

    public function updateCartItem(User $user, $cartItemData){
        if($this->productRepository->getStockProduct($cartItemData['product_id']) < $cartItemData['quantity']){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Product stock is not enough for this quantity'
                ], 400)
            );
        }

        if(!$this->cartItemRepository->productAlreadyInCart($user->cart->id, $cartItemData['product_id'])){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Product not in your cart'
                ], 400)
            );
        }

        return $this->cartItemRepository->updateQuantityCartItem($user->cart->id, $cartItemData);
    }

    public function deleteCartItem(User $user, $productId){
        if(!$this->cartItemRepository->productAlreadyInCart($user->cart->id, $productId)){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Product not in your cart'
                ], 400)
            );
        }

        return $this->cartItemRepository->deleteCartItem($user->cart->id, $productId);
    }

    public function clearCart(User $user){
        return $this->cartItemRepository->clearCart($user->cart->id);
    }
}
