<?php

namespace App\Services\AssignDriver;

use App\Models\Order;
use Override;
use App\Exceptions\InvalidOrderException;
class LeastBusyDriverService extends BaseAssignDriverService{
    #[Override]
    public function getDriver(Order $order)
    {
        $this->validateOrder($order);
        $this->ensureSystemHasDrivers();

        $driver= $this->strategy->getDriver();

        return $driver;
    }

    protected function validateOrder(Order $order): void
    {
        if ($order->status !== 'pending') {
            throw new InvalidOrderException('This Order isn\'t pending',422);
        }
    }
}