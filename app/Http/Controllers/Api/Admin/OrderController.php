<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\AdminOrderService;
use App\Http\Resources\OrderResource;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\DB;
class OrderController extends Controller
{
    use ApiResponse;
    public function __construct(private AdminOrderService $service){}

    public function getTodayOrders()
    {
        $orders = Order::createdToday()->WithDetails()->get();
        return $this->successResponse(data:OrderResource::collection($orders),
                                        message:'Today\'s orders retrieved successfully');
    }

    public function getDriverOrders(User $driver){
        $orders = $this->service->getDriverOrders($driver);
        return $this->successResponse(data:OrderResource::collection($orders),
                                        message:'Driver\'s orders retrieved successfully');
    }

    public function getDelayedOrders(){
        $orders = Order::delayedAssignment()->withDetails()->get();
        return $this->successResponse(data:OrderResource::collection($orders) ,
                                        message:'Delayed orders retrieved successfully');
    }

    
}
