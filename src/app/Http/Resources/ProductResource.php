<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'stock' => $this->stock,
            'price' => $this->price,
            'image_path' => $this->image_path,
            'category' => new CategoryResource($this->whenLoaded('category')),
            'discounts' => DiscountResource::collection($this->whenLoaded('discounts')),
        ];
    }
}
