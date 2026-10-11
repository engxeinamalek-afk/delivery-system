<?php

namespace App\Http\Controllers\Api\Driver;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Http\Resources\OrderResource;
use App\Services\DriverOrderService;
class OrderController extends Controller
{
    public function __construct(private DriverOrderService $driverOrderService){}

    public function index(){
        $driverId= Auth::user()->id;
        $orders = Order::assignedToday()->forDriver($driverId)->statusAssigned()->WithDetails()->get();
        return response()->json([
            'message' => 'Driver\'s orders retrieved successfully',
            'data' => OrderResource::collection($orders),
        ],200);
    }

    public function takeOrder(Order $order){
        $driverId = Auth::user()->id;
        $this->driverOrderService->takeOrder($driverId, $order);
        return response()->json([
            'message' => 'Order taken successfully',
        ],200);
    }

    public function deliverOrder(Order $order){
        $driverId = Auth::user()->id;
        $this->driverOrderService->deliverOrder($driverId, $order);
        return response()->json([
            'message' => 'Order delivered successfully',
        ],200);
    }
}
