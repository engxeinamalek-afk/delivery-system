<?php

namespace App\Services;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Models\Store;
use App\Exceptions\StoreInactiveException;
class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
    public function createOrder(array $data): Order
    {
        $this->isActiveStore($data['store_id']);

        return DB::transaction(function () use ($data) {
            
            $order = Order::create([
                'customer_id' => $data['customer_id'],
                'store_id' => $data['store_id'],
                'status' => OrderStatus::PENDING->value,
            ]);

            foreach ($data['items'] as $itemData) {
                $itemData['order_id'] = $order->id;
                
                OrderItem::create([
                    'item_name' => $itemData['item_name'],
                    'details'   => $itemData['details'] ?? null,
                    'order_id'  => $itemData['order_id']
                ]);
            }

            return $order;
        });
    }

    private function isActiveStore(int $storeId){
        $store = Store::find($storeId); //الglobal scope رح تعتبرو غير موجود بس لو كان غير موجود فعليا بالجدول فالفاليديشن رح يوقفو

        if (!$store) {
            throw new StoreInactiveException("This store is inactive now.");
        }
    }
}
