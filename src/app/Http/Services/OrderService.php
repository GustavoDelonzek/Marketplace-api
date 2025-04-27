<?php

namespace App\Http\Services;

use App\Events\OrderCreated;
use App\Exceptions\Business\ProductStockIsNotEnoughException;
use App\Exceptions\Http\BadRequestException;
use App\Exceptions\Http\NotFoundException;
use App\Exceptions\Http\UnauthorizedException;
use App\Http\Repositories\AddressRepository;
use App\Http\Repositories\CartItemRepository;
use App\Http\Repositories\CartRepository;
use App\Http\Repositories\CouponRepository;
use App\Http\Repositories\DiscountRepository;
use App\Http\Repositories\OrderItemRepository;
use App\Http\Repositories\OrderRepository;
use App\Http\Repositories\ProductRepository;
use App\Http\Resources\OrderResource;
use App\Http\Traits\CanLoadRelationships;
use App\Jobs\SendEmailOrderCreated;
use App\Jobs\SendEmailStatusOrder;
use App\Models\Order;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

class OrderService{
    use CanLoadRelationships;

    private array $relations = [
        'address',
        'coupon',
        'orderItems.product',
    ];

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
        $queryOrders =$this->orderRepository->getAllOrdersUser($userId);

        $orders = $this->loadRelationships($queryOrders)->get();

        return OrderResource::collection($orders);
    }

    public function validateAddress($user, $addressId){
        if(!$this->addressRepository->addressIsFromUser($addressId, $user->id)){
            throw new UnauthorizedException('Address not belongs to this user');
        }
    }

    public function validateCart($user){
        if(count($user->cart->cartItems) == 0){
            throw new BadRequestException('Your cart is empty!');
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
            throw new BadRequestException('Coupon date is invalid');
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
                $stockProduct = $this->productRepository->getStockProduct($cartItem->product_id);
                if($stockProduct < $cartItem->quantity){
                    throw new ProductStockIsNotEnoughException();
                }
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
            SendEmailOrderCreated::dispatch($user, $createdOrder);
            OrderCreated::dispatch($createdOrder);
            return $createdOrder;
        } catch(Exception $e){
            DB::rollBack();
            throw $e;
        }
    }

    public function showOrder($userId, $orderId){
        $order = $this->orderRepository->getOrder($orderId);

        if($order->user_id !== $userId){
            throw new UnauthorizedException('Order selected not belongs this user');
        }

        $order = $this->loadRelationships($order);

        return new OrderResource($order);
    }

    public function updateStatus($updateData, $orderId){
        $updated =$this->orderRepository->alterStatus($orderId, $updateData);
        $order = $this->orderRepository->getOrder($orderId);
        SendEmailStatusOrder::dispatch($order->user, $order);
        return $updated;
    }

    public function cancelOrder(User $user, $orderId){
        $order = $this->orderRepository->getOrder($orderId);

        if($order->user_id !== $user->id){
            throw new UnauthorizedException('Order selected not belongs this user');
        }

        if($order->status !== 'processing' && $order->status !== 'pending'){
            throw new UnauthorizedException('Order not in pending or processing status, not possible to cancel');
        }

        $canceled = $this->orderRepository->cancelOrder($orderId);
        $order = $this->orderRepository->getOrder($orderId);
        SendEmailStatusOrder::dispatch($order->user, $order);
        return $canceled;
    }

    public function createRelatoryWeeklyOrder(){
        $startOfWeek = now()->startOfWeek();
        $endOfWeek = now()->endOfWeek();

        $orders = $this->orderRepository->getOrdersWeekly($startOfWeek, $endOfWeek);

        if($orders->isEmpty()){
            throw new NotFoundException('No orders found');
        }

        $pdf = Pdf::loadView('pdf.relatoryWeeklyOrders', ['orders' => $orders]);

        return $pdf->download('relatoryWeekly-' . now()->format('Y-m-d') . '.pdf');
    }
}
