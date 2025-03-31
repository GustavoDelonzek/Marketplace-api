<?php

namespace App\Http\Repositories;

use App\Models\OrderItem;

class OrderItemRepository{

    public function createOrderItem($orderItemData){
        OrderItem::create($orderItemData);
    }

    

}
