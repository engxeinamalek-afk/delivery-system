<?php
namespace App\Services;
use App\Models\Order;
use App\Models\User;
use App\Exceptions\InvalidDriverException;
class AdminOrderService
{
    public function getDriverOrders(User $driver){
        $this->validateDriver($driver);
        $orders = $driver->orders()->assignedToday()->WithDetails()->get();
        return $orders;
    }
    private function validateDriver(User $driver): void
    {
        if ($driver->role !== 'driver') {
            throw new InvalidDriverException('This user isn\'t a driver');
        }
    }

    
}