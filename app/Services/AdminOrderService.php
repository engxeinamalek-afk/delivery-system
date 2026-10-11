<?php
namespace App\Services;
use App\Models\Order;
use App\Models\User;
use App\Exceptions\InvalidDriverException;
class AdminOrderService
{
    public function getDriverOrders(int $driverId){
        $this->validateDriver($driverId);
        $orders = Order::assignedToday()->forDriver($driverId)->WithDetails()->get();
        return $orders;
    }
    private function validateDriver(int $driverId): void
    {
        $driver = User::findOrFail($driverId);
        if ($driver->role !== 'driver') {
            throw new InvalidDriverException('The specified driver isn\'t a driver.');
        }
    }

    
}