<?php

namespace App\Http\Controllers\Api\Admin;

use App\Services\AssignDriver\LongestIdleDriverService;
use App\Http\Controllers\Controller;
use App\Models\Order;

class OrderDriverController extends Controller
{
    public function assignDriver(Order $order, LongestIdleDriverService $service){
        
        $driver= $service->getDriver($order);

        $service->assignOrderToDriver($order, $driver);

        return response()->json([
            'success' => true,
            'message' => "The order assigned to the {$driver->id} driver"
        ],200);
    }
}
