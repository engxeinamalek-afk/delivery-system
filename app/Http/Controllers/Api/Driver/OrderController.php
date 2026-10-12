<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Services\DriverOrderService;
use App\Traits\ApiResponse;

class OrderController extends Controller
{
    use ApiResponse;
    public function __construct(private DriverOrderService $driverOrderService){}

    public function index(){
        $driver= Auth::user();
        $orders = $driver->orders()->assignedToday()->statusAssigned()->WithDetails()->get();
        return $this->successResponse(data:OrderResource::collection($orders),
                                        message:'Driver\'s orders retrieved successfully');
    }

    public function takeOrder(Order $order){
        $driverId = Auth::user()->id;
        $this->driverOrderService->takeOrder($driverId, $order);
        return $this->successResponse(message:'Order taken successfully');
    }

    public function deliverOrder(Order $order){
        $driverId = Auth::user()->id;
        $this->driverOrderService->deliverOrder($driverId, $order);
        return $this->successResponse(message:'Order delivered successfully');
    }
}
