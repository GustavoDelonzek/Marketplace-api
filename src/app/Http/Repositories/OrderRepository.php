<?php

namespace App\Http\Repositories;

use App\Models\Order;

class OrderRepository{


    public function getAllOrdersUser($userId){
        return Order::with('orderItems')->where('user_id', $userId)->get();
    }
}
