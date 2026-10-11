<?php

namespace App\Services\AssignDriver;

use App\Enums\OrderStatus;
use App\Exceptions\InvalidOrderException;
use App\Exceptions\NoDriversAvailableException;
use App\Models\Order;
use Override;

class LongestIdleDriverService extends BaseAssignDriverService{

    #[Override]
    public function getDriver(Order $order)
    {
        $this->validateOrder($order);
        $this->ensureSystemHasDrivers();

        $driver= $this->strategy->getDriver();
        if(!$driver)
            throw new NoDriversAvailableException('No Driver Available now!');
        return $driver;
    }

    protected function validateOrder(Order $order): void
    {
        if (in_array($order->status, [OrderStatus::PICKED_UP->value, OrderStatus::DELIVERED->value])) {
            throw new InvalidOrderException("The order is already {$order->status}",422);
        }
    }
 
}