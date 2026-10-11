<?php

namespace App\Services;

use App\Services\AssignDriver\LeastBusyDriverService;
use Illuminate\Support\Facades\DB;

class OrderDispatcherService{
    public function __construct(private OrderService $orderService ,
                                private LeastBusyDriverService $driverService){    }
    public function dispatch(array $data){
        return DB::transaction(function () use ($data) {
            $order= $this->orderService->createOrder($data);
            $driver= $this->driverService->getDriver($order);
            $this->driverService->assignOrderToDriver($order, $driver);
            return $order;
        });
    }
}