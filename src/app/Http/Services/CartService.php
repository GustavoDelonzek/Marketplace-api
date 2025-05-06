<?php

namespace App\Http\Services;

use App\Exceptions\Business\ProductNotInYourCart;
use App\Exceptions\Business\ProductStockIsNotEnoughException;
use App\Exceptions\Http\BadRequestException;
use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\DiscountRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Resources\CartResource;
use App\Http\Traits\CanLoadRelationships;
use App\Models\User;

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
        if(!$cartQuery){
            throw new ProductNotInYourCart();
        }
        $cart = $this->loadRelationships($cartQuery);
        return new CartResource($cart);
    }

    public function createCartItem(User $user,$cartItemData){
        if($this->productRepository->getStockProduct($cartItemData['product_id']) < $cartItemData['quantity']){
            throw new ProductStockIsNotEnoughException();
        }

        if($this->cartItemRepository->productAlreadyInCart($user->cart->id, $cartItemData['product_id'])){
            throw new BadRequestException('Product already in cart');
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
            throw new ProductStockIsNotEnoughException();
        }

        if(!$this->cartItemRepository->productAlreadyInCart($user->cart->id, $cartItemData['product_id'])){
            throw new ProductNotInYourCart();
        }

        return $this->cartItemRepository->updateQuantityCartItem($user->cart->id, $cartItemData);
    }

    public function deleteCartItem(User $user, $productId){
        if(!$this->cartItemRepository->productAlreadyInCart($user->cart->id, $productId)){
            throw new ProductNotInYourCart();
        }

        return $this->cartItemRepository->deleteCartItem($user->cart->id, $productId);
    }

    public function clearCart(User $user){
        return $this->cartItemRepository->clearCart($user->cart->id);
    }
}
