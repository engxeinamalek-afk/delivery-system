<?php

namespace App\Http\Resources;

use App\Enums\OrderStatus;
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
            'status' => $this->status,
            
            'customer_name' => $this->relationLoaded('customer') ? $this->customer?->name : null,
            'store_name'    => $this->relationLoaded('store') ? $this->store?->name : null,

            
            'driver_name' => $this->when($this->status !== OrderStatus::PENDING->value && $this->relationLoaded('driver'),
                                        fn() => $this->driver?->name),

            
            'items_count' => $this->order_items_count,

            'assigned_date' => $this->when($this->status === OrderStatus::ASSIGNED->value , $this->assigned_at),
            'delivery_date' => $this->when($this->status === OrderStatus::DELIVERED->value , $this->delivered_at),
            'created_at' => $this->created_at,
        ];
    }
}
