<?php

namespace App\Http\Services;

use App\Events\OrderCreated;
use App\Events\OrderStatusUpdated;
use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\CouponRepository;
use App\Http\Repositories\DiscountRepository;
use App\Http\Repositories\OrderItemRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
use App\Models\Order;
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

    public function validateAddress($user, $addressId){
        if(!$this->addressRepository->addressIsFromUser($addressId, $user->id)){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Address not belongs to this user'
                ], 400)
            );
        }
    }

    public function validateCart($user){
        if(count($user->cart->cartItems) == 0){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Your cart is empty!'
                ], 400)
            );
        }
    }

    public function addDiscount($productId){
            $discounts = $this->discountRepository->getDiscountsProduct($productId);
            $totalDiscount = $discounts->sum('discount_percentage') ?? 0;

            if($totalDiscount >= 60){
                $totalDiscount = 60;
            }

            $normalPrice = $this->productRepository->getPriceProduct($productId);
            return $normalPrice - ($normalPrice * $totalDiscount / 100);
    }

    public function applicateCupon($totalAmountLocal, array $orderData){
        $couponId = $orderData['coupon_id'] ?? null;

        if(!$couponId){
            return $totalAmountLocal;
        }

        $coupon = $this->couponRepository->showCoupon($couponId);

        if(now() < $coupon->start_date || now() > $coupon->end_date){
            throw new HttpResponseException(
                response()->json(['message' => 'Cupon date is invalid'], 400)
            );
        }

       return $totalAmountLocal = $totalAmountLocal - ($totalAmountLocal * $coupon->discount_percentage / 100);

    }

    public function createOrder($user, $orderData){
        $this->validateAddress($user, $orderData['address_id']);
        $this->validateCart($user);

        $orderData['user_id'] = $user->id;
        $orderData['order_date'] = now();
        $orderData['status'] = 'pending';

        DB::beginTransaction();
        try{
            $createdOrder = $this->orderRepository->createOrder($orderData);
            $cartItems = $user->cart->cartItems;

            $totalAmountLocal = 0;
            foreach($cartItems as $cartItem){
                $orderItem['unit_price'] = $this->addDiscount($cartItem->product_id);
                $orderItem['product_id'] = $cartItem->product_id;
                $orderItem['quantity'] = $cartItem->quantity;
                $orderItem['order_id'] = $createdOrder->id;

                $this->orderItemRepository->createOrderItem($orderItem);
                $totalAmountLocal += $orderItem['unit_price'] * $cartItem->quantity;

                $restStock = $this->productRepository->getStockProduct($cartItem->product_id) - $cartItem->quantity;

                $this->productRepository->updateStock($cartItem->product_id, $restStock);
            }

            $totalAmountLocal = $this->applicateCupon($totalAmountLocal, $orderData);
            $this->orderRepository->addTotalAmount($createdOrder->id, $totalAmountLocal);
            $this->cartItemRepository->clearCart($user->cart->id);

            DB::commit();
            OrderCreated::dispatch($user, $createdOrder);
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


        $updated =$this->orderRepository->alterStatus($orderId, $updateData);
        OrderStatusUpdated::dispatch($user, $updateData['status'], $this->orderRepository->getOrder($orderId));
        return $updated;
    }

    public function cancelOrder(User $user, $orderId){
        $order = $this->orderRepository->getOrder($orderId);

        if($order->user_id !== $user->id){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Order selected not belongs this user'
                ], 401)
            );
        }

        if($order->status !== 'processing' && $order->status !== 'pending'){
            throw new HttpResponseException(
                response()->json([
                    'message' => 'Order not in pending or processing status, not possible to cancel'
                ], 401)
            );
        }

        $canceled = $this->orderRepository->cancelOrder($orderId);
        OrderStatusUpdated::dispatch($user, 'canceled', $this->orderRepository->getOrder($orderId));
        return $canceled;
    }
}
