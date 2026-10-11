<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\AdminOrderService;
use App\Http\Resources\OrderResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    public function __construct(private AdminOrderService $service){}

    public function getTodayOrders()
    {
        $orders = Order::createdToday()->WithDetails()->get();
        return response()->json([
            'message' => 'Today\'s orders retrieved successfully',
            'data' => OrderResource::collection($orders),
        ],200);
    }

    public function getDriverOrders(User $driver){
        $orders = $this->service->getDriverOrders($driver);
        return response()->json([
            'message' => 'Driver\'s orders retrieved successfully',
            'data' => OrderResource::collection($orders),
        ],200);
    }

    public function getDelayedOrders(){
        $orders = Order::delayedAssignment()->withDetails()->get();
        return response()->json([
            'message' => 'Delayed orders retrieved successfully',
            'data' => OrderResource::collection($orders),
        ],200);
    }

    
}
