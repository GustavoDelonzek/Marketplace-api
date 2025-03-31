<?php

namespace App\Http\Repositories;

use App\Models\Order;

class OrderRepository{


    public function getAllOrdersUser($userId){
        return Order::with('orderItems')->where('user_id', $userId)->get();
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
        return Order::findOrFail($orderId);
    }

    public function alterStatus($orderId, $orderData){
        return Order::where('id', $orderId)->update($orderData);
    }
}
