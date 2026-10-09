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
            'status' => $this->status,
            
            'customer_name' => $this->customer?->name,
            
            'store_name' => $this->store->name,
            
            'driver_name' => $this->when($this->status !== 'pending',$this->driver?->name),
            
            'items_count' => $this->order_items_count,

            'assigned_date' => $this->when($this->status === 'assigned', $this->assigned_at),
            'delivery_date' => $this->when($this->status === 'delivered', $this->delivered_at),
            'created_at' => $this->created_at,
        ];
    }
}
