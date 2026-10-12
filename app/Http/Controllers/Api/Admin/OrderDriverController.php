<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\AssignDriver\LongestIdleDriverService;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Traits\ApiResponse;

class OrderDriverController extends Controller
{
    use ApiResponse;
    public function assignDriver(Order $order, LongestIdleDriverService $service){
        
        $driver= $service->getDriver($order);

        $service->assignOrderToDriver($order, $driver);
        return $this->successResponse(message:"The order assigned to the {$driver->id} driver"  );
    }
}
