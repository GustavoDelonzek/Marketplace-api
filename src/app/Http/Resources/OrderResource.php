<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'address_id' => $this->address_id,
            'order_date' => $this->order_date,
            'status' => $this->status,
            'total_amount' => $this->total_amount,
            'coupon_id' => $this->whenNotNull($this->coupon_id),
            'user' => new UserResource($this->whenLoaded('user')),
            'coupon' => new CouponResource($this->whenLoaded('coupon')),
            'address' => new AddressResource($this->whenLoaded('address')),
            'order_items' => OrderItemResource::collection($this->whenLoaded('orderItems')),
        ];
    }
}
