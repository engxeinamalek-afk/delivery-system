<?php 

namespace App\Services;
use App\Enums\OrderStatus;
use App\Models\Order;
use App\Exceptions\InvalidOrderException;

class DriverOrderService{
    public function takeOrder(int $driverId, Order $order){
        $this->validateOrder($driverId, $order);
        $this->validateOrderStatus($order, OrderStatus::ASSIGNED);

        $order->update([
            'status' => OrderStatus::PICKED_UP->value,
        ]);

        return $order;
    }


    public function deliverOrder(int $driverId, Order $order){
        $this->validateOrder($driverId, $order);
        $this->validateOrderStatus($order, OrderStatus::PICKED_UP);
        
        $order->update([
            'status' => OrderStatus::DELIVERED->value,
            'delivered_at' => now(),
        ]);

        return $order;
    }

    private function validateOrder(int $driverId, Order $order){
        if($order->driver_id !== $driverId ){
            throw new InvalidOrderException('Invalid order for the specified driver.',403);
        }
    }

    private function validateOrderStatus(Order $order, OrderStatus $validStatus){
        if($order->status !== $validStatus->value){
            throw new InvalidOrderException("This order wasn't {$validStatus->value}",422);
        }
    }
}