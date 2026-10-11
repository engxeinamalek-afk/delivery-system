<?php
namespace App\Services\AssignDriver;

use App\Enums\OrderStatus;
use App\Exceptions\InvalidOrderException;
use App\Exceptions\NoDriversAvailableException;
use App\Models\Order;
use App\Models\User;
use App\Services\AssignDriver\Strategies\DriverSelectionInterface;
abstract class BaseAssignDriverService {
    public function __construct(protected DriverSelectionInterface $strategy) {}

    public function assignOrderToDriver(Order $order,User $bestDriver) {

        $order->update([
            'driver_id' => $bestDriver->id,
            'status' => OrderStatus::ASSIGNED->value,
            'assigned_at' => now()
        ]);
    }
    abstract public function getDriver(Order $order);

    protected function ensureSystemHasDrivers(): void
    {
        // للتحقق من سائقين في جدول اليوزر
        if (! User::drivers()->exists()) {
            throw new NoDriversAvailableException('No drivers available in the system.');
        }
    }
}