<?php

namespace App\Http\Repositories;

use App\Models\Order;

class OrderRepository{


    public function getAllOrdersUser($userId){
        return Order::with('orderItems')->where('user_id', $userId);
    }

    public function createOrder($orderData){
        return Order::create($orderData);
    }

    public function addTotalAmount($orderId,$totalAmount){
        return Order::where('id', $orderId)->update([
            'total_amount' => $totalAmount
        ]);
    }

    public function getOrder($orderId){
        return Order::with('orderItems')->findOrFail($orderId);
    }

    public function alterStatus($orderId, $orderData){
        return Order::where('id', $orderId)->update($orderData);
    }

    public function cancelOrder($orderId){
        return Order::where('id', $orderId)->update([
            'status' => 'canceled'
        ]);
    }

    public function getOrdersWeekly($startOfWeek, $endOfWeek){
        return Order::whereBetween('order_date', [$startOfWeek, $endOfWeek])->get();
    }

}
