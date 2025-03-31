<?php

namespace App\Http\Services;

use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\CouponRepository;
use App\Http\Repositories\DiscountRepository;
use App\Http\Repositories\OrderItemRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
use App\Models\User;
use DateTime;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class OrderService{
    public function __construct(
        protected OrderRepository $orderRepository,
        protected ProductRepository $productRepository,
        protected CartRepository $cartRepository,
        protected CartItemRepository $cartItemRepository,
        protected DiscountRepository $discountRepository,
        protected AddressRepository $addressRepository,
        protected CouponRepository $couponRepository,
        protected OrderItemRepository $orderItemRepository

        )
    {

    }

    public function allOrders($userId){
        return $this->orderRepository->getAllOrdersUser($userId);
    }

    public function createOrder($user, $orderData){


        if(!$this->addressRepository->addressIsFromUser($orderData['address_id'], $user->id)){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Address not belongs to this user'
                ], 400)
            );
        }

        $orderData['user_id'] = $user->id;
        $orderData['order_date'] = now();
        $orderData['status'] = 'pending';

        DB::beginTransaction();

        try{
            $createdOrder = $this->orderRepository->createOrder($orderData);

            $cartItems = $user->cart->cartItems;

            if(count($cartItems) == 0){
                throw new HttpResponseException(
                    response()->json([
                        'message' => 'Your cart is empty!'
                    ], 400)
                );
            }

            $totalAmountLocal = 0;
            foreach($cartItems as $cartItem){
                $discounts = $this->discountRepository->getDiscountsProduct($cartItem->product_id);
                $totalDiscount = $discounts->sum('discount_percentage') ?? 0;

                if($totalDiscount >= 60){
                    $totalDiscount = 60;
                }

                $normalPrice = $this->productRepository->getPriceProduct($cartItem->product_id);

                $orderItem['unit_price'] = $normalPrice - ($normalPrice * $totalDiscount / 100);
                $orderItem['product_id'] = $cartItem->product_id;
                $orderItem['quantity'] = $cartItem->quantity;
                $orderItem['order_id'] = $createdOrder->id;

                $this->orderItemRepository->createOrderItem($orderItem);

                $totalAmountLocal += $orderItem['unit_price'] * $cartItem->quantity;

                $restStock = $this->productRepository->getStockProduct($cartItem->product_id) - $cartItem->quantity;

                $this->productRepository->updateStock($cartItem->product_id, $restStock);
            }

            $couponId = $orderData['coupon_id'] ?? null;

            if($couponId){
                $coupon = $this->couponRepository->showCoupon($couponId);
                if(now() < $coupon->start_date || now() > $coupon->end_date){
                    throw new HttpResponseException(
                        response()->json(['message' => 'Cupon is invalid'], 400)
                    );
                }
                $totalAmountLocal = $totalAmountLocal - ($totalAmountLocal * $coupon->discount_percentage / 100);
             }

            $this->orderRepository->addTotalAmount($createdOrder->id, $totalAmountLocal);
            $this->cartItemRepository->clearCart($user->cart->id);

            DB::commit();
            return $createdOrder;
        } catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function showOrder($userId, $orderId){
        $order = $this->orderRepository->getOrder($orderId);

        if($order->user_id !== $userId){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Order selected not belongs this user'
                ])
            );
        }

        return $order;
    }

    public function updateStatus(User $user, $updateData, $orderId){
        if($user->role !== 'admin' && $user->role !== 'moderator'){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Permission denied for this action'
                ], 401)
            );
        }
        
        return $this->orderRepository->alterStatus($orderId, $updateData);
    }
}
