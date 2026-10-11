<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Services\OrderDispatcherService;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(private OrderDispatcherService $service){}
    public function store(StoreOrderRequest $request)
    {
        $validatedData = $request->validated();
        $validatedData['customer_id'] = $request->user()->id;

        $order= $this->service->dispatch($validatedData);

        return response()->json([
            'message' => 'Order created successfully',
            'order' => $order,
        ], 201);

    }
}
