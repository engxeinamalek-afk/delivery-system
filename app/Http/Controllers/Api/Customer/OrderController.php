<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Services\OrderDispatcherService;
use App\Services\OrderService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    use ApiResponse;
    public function __construct(private OrderDispatcherService $service){}
    public function store(StoreOrderRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['customer_id'] = $request->user()->id;

        $order= $this->service->dispatch($validatedData);
        $order->load(['customer', 'store', 'driver'])->loadCount('orderItems');
        return $this->successResponse(data: new OrderResource($order),
                                        message: 'Order created successfully',
                                        statusCode:201);

    }
}
