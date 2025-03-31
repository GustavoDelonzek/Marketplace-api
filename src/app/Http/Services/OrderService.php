<?php

namespace App\Http\Services;

use App\Http\Repositories\OrderRepository;

class OrderService{
    public function __construct(protected OrderRepository $orderRepository)
    {

    }

    public function allOrders($userId){
        return $this->orderRepository->getAllOrdersUser($userId);
    }
}
